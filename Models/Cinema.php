<?php namespace Models;

Class Cinema
{

      // $count = self::$count++;
       // $idCinema = $count;
       // echo ($idCinema);
       // echo (self::$count);


  //  public static $count = 0;
    private $id; 
    private $name;
    private $address;
    private $openning;
    private $closing;
    private $ticketValue;

    function __construct($name, $address, $openning, $closing, $ticketValue)
    {
      //  $count = self::$count++; 
      //  $this->id=$count;
       // echo "<br>";
      //  echo $count;
     //   echo "<br>";
        //echo $this->getId();
        $this->name=$name;
        $this->address=$address;
        $this->openning=$openning;
        $this->closing=$closing;
        $this->ticketValue=$ticketValue;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getTicketValue()
    {
        return $this->ticketValue;
    }

    public function setName($name)
    {
        $this->name=$name;
    }

    public function setAddress($address)
    {
        $this->address=$address;
    }

    public function setTicketValue($ticketValue)
    {
        $this->ticketValue=$ticketValue;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getOpenning()
    {
        return $this->openning;
    }

    public function setOpenning($openning)
    {
        $this->openning = $openning;

        return $this;
    }

    public function getClosing()
    {
        return $this->closing;
    }

    public function setClosing($closing)
    {
        $this->closing = $closing;

        return $this;
    }
}
