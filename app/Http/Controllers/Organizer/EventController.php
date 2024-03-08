<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category; // Make sure to import the Category model

class EventController extends Controller
{

    public function index2()
{
    $events = Event::all(); // Fetch all events
    return view('organizer.events.index', compact('events')); // Pass events to the view
}
    public function index(){
        $categories = Category::all(); // Fetch all categories from the database
        return view('organizer.events.create', compact('categories')); // Pass the categories to the view
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'available_spots' => 'required|integer',
            'image' => 'sometimes|file|image|max:5000', // Example validation
        ]);

        // Handle file upload for the image, if it exists
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('event_images', 'public');
        }

        // Create the event
        Event::create($data);

        // Redirect or return response
        return redirect()->route('organizer.events.index')->with('success', 'Event created successfully.');
    }
}
