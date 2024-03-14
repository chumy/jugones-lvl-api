<?php

namespace App\Providers;

use Carbon\Carbon;
use DateTime;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Log;


class Reserva {
    public $reservaId;
    public $titulo;
    public $descripcion;
    public $fecha;
    public $link;
    public $sesion;
    public $sala;
    



     public function __construct(Event $event){
        $this->reservaId = $event->id;
        $this->titulo = $event->summary;
        $this->descripcion = $event->description;
        //$this->start = $event->start->dateTime;
        //$this->end = $event->end->dateTime;
        $this->sala = $event->location;
        $this->link = $event->htmlLink;

        $hora = $event->start->dateTime;
        
        $this->fecha = Carbon::createFromFormat(DateTime::RFC3339, $hora)->format("Y-m-d");
        $hora= Carbon::createFromFormat(DateTime::RFC3339, $hora)->format("H");
        $this->sesion ='Matí';
        if ($hora > 14)
            $this->sesion = 'Tarda';
        
    }

  
    /*"googleEvent":
            {"anyoneCanAddSelf":null,"attendeesOmitted":null,"colorId":null,"created":"2024-03-12T16:39:47.000Z",
                "description":null,
                "endTimeUnspecified":null,"etag":"\"3420523174334000\"",
            "eventType":"default",
                "guestsCanInviteOthers":null,"guestsCanModify":null,"guestsCanSeeOtherGuests":null,"hangoutLink":null,
            "htmlLink":"https:\/\/www.google.com\/calendar\/event?eid=N2lnYTBzMjZvcmI4OHZtaDUzZXE5MWo1dGkgMDdkMTU3YmQyZGZmMjEwNDg0OTkzZGJhZDgyZTAyOWM2MWM0M2EyMTI2ZjBkNWZmMTUzMGZiMGEwMTQ4NGVjN0Bn",
            "iCalUID":"7iga0s26orb88vmh53eq91j5ti@google.com",
            "id":"7iga0s26orb88vmh53eq91j5ti",
            "kind":"calendar#event","location":null,"locked":null,"privateCopy":null,"recurrence":null,"recurringEventId":null,"sequence":0,"status":"confirmed",
            "summary":"Torneo Heat",
            "transparency":null,"updated":"2024-03-12T16:39:47.167Z","visibility":null,
            "creator":{"displayName":null,"email":"jugonesmolinsderol@gmail.com","id":null,"self":null},
            "organizer":{"displayName":"Reserves","email":"07d157bd2dff210484993dbad82e029c61c43a2126f0d5ff1530fb0a01484ec7@group.calendar.google.com", "id":null,"self":true},
            "start":{"date":null,"dateTime":"2024-04-06T16:00:00+02:00","timeZone":"Europe\/Madrid"},
            "end":{"date":null,"dateTime":"2024-04-06T20:00:00+02:00","timeZone":"Europe\/Madrid"},
            "reminders":{"useDefault":true}
            }*/
        
        /* Evento 
            id
            

        */

}