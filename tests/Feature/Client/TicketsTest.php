<?php

namespace Tests\Feature\Client;

use App\Mail\TicketClosed;
use App\Mail\TicketCommented;
use App\Mail\TicketCreated;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Mail;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * @property User $client
 */
class TicketsTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = factory(User::class)->create(['role' => User::ROLE_CLIENT]);
    }

    public function testCreate()
    {
        $this->actingAs($this->client)
            ->get(route('tickets.create'))
            ->assertStatus(Response::HTTP_OK);

        $uniqTheme = uniqid();
        $attachmentContent = $this->faker->sentence;

        $storeResponse = $this
            ->actingAs($this->client)
            ->post(route('tickets.store'), [
                'theme' => $uniqTheme,
                'content' => $this->faker->text,
                'attachment' => UploadedFile::fake()->createWithContent('test.txt', $attachmentContent),
            ]);

        $ticket = Ticket::where('theme', '=', $uniqTheme)->firstOrFail();

        $storeResponse->assertRedirect(route('tickets.show', $ticket))
            ->assertSessionHas('success', 'Заявка успешно создана');

        self::assertEquals($attachmentContent, \Storage::disk('public')->get($ticket->attachment));
    }

    public function testUpdate()
    {
        $ticket = factory(Ticket::class)->create([
            'client_id' => $this->client->id,
            'attachment' => null,
        ]);

        $this->actingAs($this->client)
            ->get(route('tickets.edit', $ticket))
            ->assertStatus(Response::HTTP_OK);

        $newTheme = $this->faker->sentence;

        $this->actingAs($this->client)
            ->put(route('tickets.update', $ticket), [
                'theme' => $newTheme,
                'content' => $ticket->content,
            ])
            ->assertRedirect(route('tickets.show', $ticket))
            ->assertSessionHas('success', 'Заявка успешно обновлена');

        $ticket->refresh();

        self::assertEquals($newTheme, $ticket->theme);
    }

    public function testClose()
    {
        $ticket = factory(Ticket::class)->create([
            'client_id' => $this->client->id,
            'status' => Ticket::STATUS_IN_PROGRESS,
        ]);

        $this->actingAs($this->client)
            ->post(route('tickets.close', $ticket))
            ->assertRedirect(route('tickets.show', $ticket))
            ->assertSessionHas('success', 'Заявка успешно закрыта');

        $ticket->refresh();
        self::assertTrue($ticket->isClosed());
    }

    public function testTicketCreatedSent()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);

        $this
            ->actingAs($this->client)
            ->post(route('tickets.store'), [
                'theme' => $this->faker->sentence,
                'content' => $this->faker->text,
                'attachment' => UploadedFile::fake()->create('test.txt'),
            ]);

        $ticket = $this->client->tickets()->first();

        Mail::assertSent(TicketCreated::class, function (TicketCreated $ticketCreated) use ($ticket, $manager) {
            return $ticketCreated->ticket->id === $ticket->id
                && $ticketCreated->hasTo($manager);
        });
    }

    public function testTicketCommentedSentToManager()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);
        $ticket = factory(Ticket::class)->create([
            'status' => Ticket::STATUS_IN_PROGRESS,
            'manager_id' => $manager->id,
            'client_id' => $this->client->id,
        ]);

        $this
            ->actingAs($this->client)
            ->post(route('comments.store', $ticket), [
                'theme' => $this->faker->sentence,
                'content' => $this->faker->text,
                'attachment' => UploadedFile::fake()->create('test.txt'),
            ]);

        Mail::assertSent(TicketCommented::class, function (TicketCommented $ticketCommented) use ($manager) {
            return $ticketCommented->hasTo($manager)
                && ! $ticketCommented->hasTo($this->client);
        });
    }

    public function testTicketCommentedSentToClient()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);
        $ticket = factory(Ticket::class)->create([
            'status' => Ticket::STATUS_IN_PROGRESS,
            'manager_id' => $manager->id,
            'client_id' => $this->client->id,
        ]);

        $this
            ->actingAs($manager)
            ->post(route('comments.store', $ticket), [
                'theme' => $this->faker->sentence,
                'content' => $this->faker->text,
                'attachment' => UploadedFile::fake()->create('test.txt'),
            ]);

        Mail::assertSent(TicketCommented::class, function (TicketCommented $ticketCommented) use ($manager) {
            return $ticketCommented->hasTo($this->client)
                && ! $ticketCommented->hasTo($manager);
        });
    }

    public function testTicketClosedSent()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);
        $ticket = factory(Ticket::class)->create([
            'status' => Ticket::STATUS_IN_PROGRESS,
            'manager_id' => $manager->id,
            'client_id' => $this->client->id,
        ]);

        $this->actingAs($this->client)
            ->post(route('tickets.close', $ticket));

        Mail::assertSent(TicketClosed::class, function (TicketClosed $ticketClosed) use ($manager) {
            return $ticketClosed->hasTo($manager);
        });
    }
}
