<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Events;

class EventController extends Controller
{
  public function index(){
    return view('home');
  }

  public function create(Request $req){
    $title = $req->title;
    $sdate = $req->sdate;
    $edate = $req->edate;
    $eafter = $req->eafter;
    $repeat = $req->repeat;
    $repeatDay = $req->repeatDay;
    $frequency = $req->frequency;
    $endWhen = $req->when;
    
    if($repeat != 'Week'){
      $repeatDay = null;
    }

    if($repeat != 'Month'){
      $frequency = 0;
    }

    if(empty(trim($title))){
      echo json_encode(['status' => 'error', 'msg' => 'Title is required']);
      exit;
    }
  
    if(empty(trim($sdate))){
      echo json_encode(['status' => 'error', 'msg' => 'Start date is required']);
      exit;
    }
  
    if($repeat == 'Month' && $frequency < 1){
      echo json_encode(['status' => 'error', 'msg' => 'Month repeat frequency must be at least 1.']);
      exit;
    }
  
    if($endWhen == 'date' && empty(trim($edate))){
      echo json_encode(['status' => 'error', 'msg' => 'End date cannot be empty.']);
      exit;
    }

    if($endWhen == 'occr' && empty(trim($eafter))){
      echo json_encode(['status' => 'error', 'msg' => 'End after occurence cannot be empty.']);
      exit;
    }
    
    $stmt = Events::create([
      'title' => $title,
      'start_date' => $sdate,
      'end_date' => ($endWhen == 'occr')?null:$edate,
      'occurrences' => $eafter,
      'repeat_every' => $repeat,
      'day_repeat' => $repeatDay,
      'frequency' => $frequency
    ]);

    if($stmt){
      echo json_encode(['status' => 'success', 'msg' => 'New event created successfully.']);
    }else{
      echo json_encode(['status' => 'error', 'msg' => 'Some error occured']);
    }
  }

  public function show(){
    $data = Events::all();
    return view('list', compact('data'));
  }

  public function destroy(Request $req){
    $stmt = Events::where('id', '=', $req->id)->delete();
    $data = Events::all();
    
    $html = '';
    foreach($data as $key => $val){
      $html .= '<tr>
                  <td>'.++$key.'</td>
                  <td>'.$val['title'].'</td>
                  <td>
                    <a href="#" class="btn btn-sm btn-info view" data-bs-toggle="modal" data-id="'.$val['id'].'" data-bs-target="#exampleModal">View</a>
                    <a href="#" class="btn btn-sm btn-danger action" data-type="delete" data-id="'.$val['id'].'">Delete</a>
                  </td>
                </tr>';
    }

    if($stmt){
      echo json_encode(['status' => 'success', 'msg' => 'Event deleted successfully.', 'html' => $html]);
    }else{
      echo json_encode(['status' => 'error', 'msg' => 'Some error occured']);
    }
  }

  public function event(Request $req){
    $stmt = Events::where('id', '=', $req->id)->get();
    
    $occurrences = $stmt[0]['occurrences'];
    $startDate = $stmt[0]['start_date'];
    $endDate = $stmt[0]['end_date'];
    $sDate = date('Y-m-d', strtotime($stmt[0]['start_date']. '-1 day'));
    $repeat = $stmt[0]['repeat_every'];

    $eventDates = [];

    if($occurrences != 0){
      if($repeat == 'Day'){
        $lastDay = date('Y-m-d', strtotime($sDate.'+'.$occurrences.' days'));

        while($startDate <= $lastDay){
          array_push($eventDates, $startDate);
          $startDate = date('Y-m-d', strtotime($startDate.'+1 day'));
        }
        
      }
      
      if($repeat == 'Week'){
        $lastWeek = date('Y-m-d', strtotime($sDate.'+'.$occurrences.' week'));
        $repeatDay = $stmt[0]['day_repeat'];

        $eventDates = [];
        
        while($startDate <= $lastWeek){
          if(date('l', strtotime($startDate)) == $repeatDay){
            array_push($eventDates, $startDate);
          }
          $startDate = date('Y-m-d', strtotime($startDate.'+1 day'));
        }
      }

      if($repeat == 'Month'){
        $frequency = $stmt[0]['frequency'];
        $nextMonth = date('Y-m-d', strtotime($startDate.'+'.$frequency.' months'));
        
        $eventDates = [];
        $count = 1;

        while($count <= $occurrences){
          $nextMonth = $startDate;
          if(!in_array($nextMonth, $eventDates)){
            array_push($eventDates, $nextMonth);
          }
          $startDate = date('Y-m-d', strtotime($nextMonth.'+'.$frequency.' months'));
          $count++;
        }
      }

      if($repeat == 'Year'){
        $lastYear = date('Y-m-d', strtotime($sDate.'+'.$occurrences.' years'));

        $eventDates = [];

        while(date('Y', strtotime($startDate)) <= date('Y', strtotime($lastYear))){
          array_push($eventDates, $startDate);
          $startDate = date('Y-m-d', strtotime($startDate.'+1 years'));
        }
      }
    }else{
      if($repeat == 'Day'){
        $eventDates = [];

        while($startDate <= $endDate){
          array_push($eventDates, $startDate);
          $startDate = date('Y-m-d', strtotime($startDate.'+1 day'));
        }
      }
      
      if($repeat == 'Week'){
        $repeatDay = $stmt[0]['day_repeat'];

        $eventDates = [];
        
        while($startDate <= $endDate){
          if(date('l', strtotime($startDate)) == $repeatDay){
            array_push($eventDates, $startDate);
          }
          $startDate = date('Y-m-d', strtotime($startDate.'+1 day'));
        }
      }

      if($repeat == 'Month'){
        $frequency = $stmt[0]['frequency'];
        $nextMonth = $startDate;
        $eventDates = [];
          
        while($nextMonth <= $endDate){
          array_push($eventDates, $nextMonth);
          $nextMonth = date('Y-m-d', strtotime($nextMonth.'+'.$frequency.' months'));
        }
      }

      if($repeat == 'Year'){
        $eventDates = [];

        while(date('Y', strtotime($startDate)) <= date('Y', strtotime($endDate))){
          array_push($eventDates, $startDate);
          $startDate = date('Y-m-d', strtotime($startDate.'+1 years'));
        }
      }
    }

    $html = '<div class="date-container">';

    foreach($eventDates as $key => $val){

      $html .= '<div class="date-box">
                  <div class="year">'.date('Y', strtotime($val)).'</div>
                  <div class="month-date">
                    <div class="month">'.date('F', strtotime($val)).'</div>
                    <div class="date">'.date('jS', strtotime($val)).'</div>  
                  </div>
                  <div class="day">'.date('l', strtotime($val)).'</div>
                </div>';
    }

    $html .= "</div>";

    return json_encode(['title' => $stmt[0]['title'], 'event' => $html]);
  }
}
