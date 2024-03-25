<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        //return Advertisement::withTrashed()->where("user_id", $user->id)->get();
        return $user->advertisements;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request)
    {
        $user = auth()->user();
        $advertisement = new Advertisement();
        $advertisement->title = $request->title;
        $advertisement->description = $request->description ? $request->description : "";
        $advertisement->user_id = $user->id;
        $file = $request->file("image");
        if (!is_null($file)) {
            $image = $file->store("images/advertisements", ["disk" => "public"]);
            $advertisement->image = "storage/".$image;
        }

        $advertisement->save();
        return $advertisement;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $advertisement = Advertisement::find($id);
        if (is_null($advertisement)) {
            return response()->json(["message" => "Advertisement not found: $id"], 404);
        }
        $this->authorize("view", $advertisement);
        return $advertisement;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, string $id)
    {
        $advertisement = Advertisement::find($id);
        if (is_null($advertisement)) {
            return response()->json(["message" => "Advertisement not found: $id"], 404);
        }
        $this->authorize("update", $advertisement);
        if (!is_null($request->title)) {
            $advertisement->title = $request->title;
        }
        $advertisement->description = $request->description ? $request->description : "";
        $file = $request->file("image");
        if (!is_null($file)) {
            $image = $file->store("images/advertisements", ["disk" => "public"]);
            $advertisement->image = "storage/".$image;
        }

        $advertisement->save();
        return $advertisement;
    }

    public function removeImage(string $id)
    {
        $advertisement = Advertisement::find($id);
        if (is_null($advertisement)) {
            return response()->json(["message" => "Advertisement not found: $id"], 404);
        }
        $this->authorize("update", $advertisement);
        $advertisement->image = null;
        $advertisement->save();
        return $advertisement;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertisement = Advertisement::find($id);
        if (is_null($advertisement)) {
            return response()->json(["message" => "Advertisement not found: $id"], 404);
        }
        $this->authorize("delete", $advertisement);
        $advertisement->delete();
        return response()->noContent();
    }

    public function all() {
        $advertisement = Advertisement::with("user")->get();
        return $advertisement;
    }

    public function showWithUser(string $id) {
        $advertisement = Advertisement::with("user")->find($id);
        if (is_null($advertisement)) {
            return response()->json(["message" => "Advertisement not found: $id"], 404);
        }
        return $advertisement;
    }
}
