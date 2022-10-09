<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Event;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Requests\{EventStoreRequest, EventUpdateRequest};

class EventController extends Controller
{
    public function index()
    {
        return new EventResource(true, 'List Events', Event::all());
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->get();
        return new EventResource(true, null, $event);
    }

    public function store(EventStoreRequest $request)
    {
        $request->validated();
        $event =  Event::create([
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'image' => request('image'),
            'date' => request('date'),
            'description' => request('description'),
            'location' => request('location'),
            'category' => request('category'),
            'organizer' => request('organizer'),
        ]);

        return new EventResource(true, 'Event berhasil ditambahkan', $event);
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        $request->validated();
        $event->update([
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'image' => request('image'),
            'date' => request('date'),
            'description' => request('description'),
            'location' => request('location'),
            'category' => request('category'),
            'organizer' => request('organizer'),
        ]);

        return new EventResource(true, 'Event berhasil diedit', $event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return new EventResource(true, 'Event berhasil dihapus', null);
    }
}
