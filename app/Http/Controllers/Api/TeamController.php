<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function joinTeam(Request $request)
    {
      //validation
      $request->validate([
          'title'=>'required',
          'description'=>'required',
          'min_number' =>'required '
      ]);

      //create team object
      $team = new Team();
    
      $team->user_id = auth()->user()->id;
      $team->title = $request->title;
      $team->description = $request->description;
      $team->min_number = $request->min_number;

      $team->save();

      //send response
      return response()->json([
          "status"=>1,
          "message"=>"joined team"
      ]);
    }
    public function totalTeams()
    {
        $id = auth()->user()->id;

        $teams = User::find($id)->teams;

        return response()->json([
            "status"=>1,
            "message"=>"total team joined",
            "data"=>$teams
        ]);

    }
    public function deleteTeam($id)
    {
        $user_id = auth()->user()->id;

        if( Team::where(["id"=> $id, "user_id"=>$user_id])->exists() )
         {
             Team::find($id)->delete();

             return response()->json([
                 "status"=>1,
                 "message"=>"successfully deleted",
             ]);

         }else{
             return response()->json([
                 "status"=>0,
                 "message"=>"not found"
             ]);
         }
    }
}
