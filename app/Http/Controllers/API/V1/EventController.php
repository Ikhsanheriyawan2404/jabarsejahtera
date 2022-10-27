<?php

namespace App\Http\Controllers\API\V1;

use App\Event;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{EventStoreRequest, EventUpdateRequest};

class EventController extends Controller
{
    public function index()
    {
        $title = request('title');
        $category = request('category');
        return new ApiResource(true, 'List Events', Event::where('category', 'like', "%$category%")->where('title', 'like', "%$title%")->latest()->get());
    }

    public function show($id)
    {
        $event = Event::find($id);
        if ($event) {
            return new ApiResource(true, 'Details event', $event);
        }
        return response()->json(new ApiResource(false, 'Donasi tidak ditemukan'), 404);
    }

    public function store(EventStoreRequest $request)
    {
        $request->validated();

        $event = Event::create([
            'title' => request('title'),
            'description' => request('description'),
            'organizer' => request('organizer'),
            'date' => request('date'),
            'location' => request('location'),
            'image' => request()->file('image')->store('img/events'),
        ]);

        return new ApiResource(true, 'Event berhasil ditambahkan', $event);
    }

    public function update($id, EventUpdateRequest $request)
    {
        $request->validated();
        $event = Event::find($id);
        if (!$event) {
            return response()->json(new ApiResource(false, 'Data tidak ditemukan', $event), 404);
        }
        if (request('image')) {
            Storage::delete($event->image);
            $image = request()->file('image')->store('img/events');
        } else {
            $image = $event->image;
        }

        $event->update([
            'title' => request('title'),
            'description' => request('description'),
            'organizer' => request('organizer'),
            'date' => request('date'),
            'location' => request('location'),
            'image' => $image,
        ]);

        return new ApiResource(true, 'Event berhasil diedit', $event);
    }

    public function destroy(Event $event)
    {
        Storage::delete($event->image);
        $event->delete();
        return new ApiResource(true, 'Event berhasil dihapus');
    }
}
