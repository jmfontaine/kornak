<?php
class Kajoa_Service_Nabaztag_Choregraphy
{
    const COMMAND_TYPE_EAR = 'motor';
    const COMMAND_TYPE_LED = 'led';

    const EAR_RIGHT = 0;
    const EAR_LEFT  = 1;
    
    const MOVE_FRONT_TO_BACK = 0;
    const MOVE_BACK_TO_FRONT = 1;
    
    protected $_commands = array();
    protected $_tempo = 10;
    
    public function __toString()
    {
        $stringCommands = array();
        foreach ($this->_commands as $command) {
            $stringCommands[] = implode(',', array_values($command));
        }
        $string = $this->_tempo . ',' . implode(',', $stringCommands);
        return $string;
    }
    
    public function addCommand($type, $time, $firstValue, $secondValue, $thirdValue, $fourthValue)
    {
        $this->_commands[] = array(
            '$time'       => $time,
            'type'        => $type,
            'firstValue'  => $firstValue,
            'secondValue' => $secondValue,
            'thirdValue'  => $thirdValue,
            'fourthValue' => $fourthValue,
        );
    }
    
    public function addEarCommand($time, $ear, $angle, $rotation)
    {
        $this->addCommand(self::COMMAND_TYPE_EAR, $time, $ear, $angle, 0, $rotation);
    }
    
    public function getTempo()
    {
        return $this->_tempo;
    }
    
    public function setTempo($tempo)
    {
        $tempo = (int)$tempo;
        if (1 > $tempo) {
            throw new Kajoa_Service_Nabaztag_Exception('Invalid tempo');
        }
        $this->_tempo = $tempo;
    }
    
    public function toString()
    {
        return $this->__toString();
    }
}
