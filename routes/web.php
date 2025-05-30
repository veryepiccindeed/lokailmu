<?php

    use Illuminate\Support\Facades\Route;
    use App\Models\Conversation; // Import Conversation model
    use Illuminate\Http\Request; // Import Request
    use App\Events\MessageSent; // Import MessageSent event
    use App\Http\Controllers\WebLoginController; // Import WebLoginController

    Route::get('/', function () {
        // If user is logged in, try to redirect to a chat, otherwise show welcome/login link
        if (auth()->check()) {
            $user = auth()->user();
            $conversation = Conversation::where('guru_id', $user->idUser)
                                        ->orWhere('mentor_id', $user->idUser)
                                        ->orderBy('last_message_at', 'desc') // Get most recent
                                        ->first();
            if ($conversation) {
                return redirect()->route('chat.test.show', ['conversation' => $conversation->id]);
            }
            return view('welcome'); // Or a dashboard if no conversations
        }
        return view('auth.login-test'); // Show login if not authenticated
    });

    // Test Login Routes
    Route::get('login-test', [WebLoginController::class, 'showLoginForm'])->name('login.test.form');
    Route::post('login-test', [WebLoginController::class, 'login'])->name('login.test.submit');
    Route::post('logout-test', [WebLoginController::class, 'logout'])->name('logout.test');

    // Route for the original chat-test view (Guru, uses web auth if you keep the middleware)
    // The original chat-test.blade.php is now modified for Guru with token placeholder.
    // So, this route will now serve that modified view.
    // The {userId} here is the ID of the user viewing (Guru)
    Route::get('/chat-guru-token/{conversation}/{guruId}', function (Conversation $conversation, $guruId) {
        if ($conversation->guru_id !== $guruId) {
            abort(403, 'Specified user is not the Guru in this conversation.');
        }
        $receiver = $conversation->mentor; // Assuming mentor relationship is loaded or exists
        if (!$receiver) {
            abort(404, 'Mentor for this conversation not found.');
        }
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        return view('chat-test', [ // chat-test.blade.php is now the Guru token view
            'conversation' => $conversation,
            'initialMessages' => $messages,
            'userId' => $guruId,
            'receiverId' => $receiver->idUser,
        ]);
    })->name('chat.guru.token');

    // Route for the new Mentor chat view with token placeholder
    Route::get('/chat-mentor-token/{conversation}/{mentorId}', function (Conversation $conversation, $mentorId) {
        if ($conversation->mentor_id !== $mentorId) {
            abort(403, 'Specified user is not the Mentor in this conversation.');
        }
        $receiver = $conversation->guru; // Assuming guru relationship is loaded or exists
        if (!$receiver) {
            abort(404, 'Guru for this conversation not found.');
        }
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        return view('chat-mentor-test', [
            'conversation' => $conversation,
            'initialMessages' => $messages,
            'userId' => $mentorId,
            'receiverId' => $receiver->idUser,
        ]);
    })->name('chat.mentor.token');


    Route::middleware(['web', 'auth'])->group(function () {
        // This route is still web-auth protected. The token-based views will have trouble sending to it
        // unless this endpoint is changed to also accept token auth, or a new API endpoint is used.
        Route::post('/chat-test/{conversation}/messages', function (Request $request, Conversation $conversation) {
            $user = auth()->user();

            if ($user->idUser !== $conversation->guru_id && $user->idUser !== $conversation->mentor_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $validated = $request->validate([
                'body' => 'required|string|max:1000',
                'receiver_id' => 'required|string|exists:users,idUser',
            ]);

            $expectedReceiverId = ($user->idUser === $conversation->guru_id) ? $conversation->mentor_id : $conversation->guru_id;
            if ($validated['receiver_id'] !== $expectedReceiverId) {
                return response()->json(['error' => 'Invalid receiver ID for this conversation.'], 400);
            }

            $message = $conversation->messages()->create([
                'sender_id' => $user->idUser,
                'receiver_id' => $validated['receiver_id'],
                'body' => $validated['body'],
            ]);
            
            $message->load('sender'); // Load sender relationship for broadcasting

            broadcast(new MessageSent($message))->toOthers();

            return response()->json($message);
        })->name('chat.test.send_message');
    });

    // If you don't have web authentication routes (login, register) set up,
    // you might need to add them for this test page to work easily.
    // For example, if you have Laravel UI:
    // Auth::routes();
    // Or install Laravel Breeze: composer require laravel/breeze && php artisan breeze:install
