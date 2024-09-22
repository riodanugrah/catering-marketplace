<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
        ]);

        $imagePath = $request->file('image')->store('menu_images', 'public');

        Menu::create([
            'merchant_id' => auth()->user()->merchantProfile->id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
        ]);

        return redirect()->route('merchant.menus');
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $menu->image = $imagePath;
        }

        $menu->update($request->only(['name', 'description', 'price']));

        return redirect()->route('merchant.menus');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('merchant.menus');
    }
}
