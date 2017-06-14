<?php



namespace ValidicUpdate {
    
    /**
    * Import and convert user activities from Validic to
    * Leon fromat. 
    *
    * @method void run()
    * @method void declareGlobalVariables()
    * @method void getIds()
    * @method void getActiviIds()
    *
    *
    */
    class Import
    {
        
        public $ids;
        public $validicObjects;
        public $activities;
        
        function run() {
            try {
                $this->declareGlobalVariables();
                $this->getIds();
                $this->getActiviIds();
            } catch (Exception $e) {
                print $e->getMessage();
            }
        }
        
        function declareGlobalVariables() {
            include('../config/config.php');
            $this->ids = new Ids();
            $this->validicObjects = array();
            $this->activities = array();
        }
        
        function getIds() {
            $mysqli = new \mysqli(host, username, password, database);
                                                                         
            if ($mysqli->connect_error) {
                throw new Exception($mysqli->connect_error);
            } else {
               
                $sql = "SELECT startdate, nextfitness, nextroutine, nextnutrition, nextsleep, nextweight, " .
                    "nextdiabetes, nextbiometrics from validicupdate";
            
                $stmt = $mysqli->prepare($sql);
                if (!$stmt) {
                    throw new Exception($mysqli->error);
                }

                if ($stmt->execute()) {
                        
                    $stmt->bind_result($startDate, $nextFitness, $nextRoutine, $nextNutrition, $nextSleep,
                                      $nextWeight, $nextDiabetes, $nextBiometrics);
        
                    while ($stmt->fetch()) {
                        $this->ids->lastupdate = new \DateTime($startDate);
                        $this->ids->nextfitness = $nextFitness;
                        $this->ids->nextroutine = $nextRoutine;
                        $this->ids->nextnutrition = $nextNutrition;
                        $this->ids->nextsleep = $nextSleep;
                        $this->ids->nextweight = $nextWeight;
                        $this->ids->nextdiabetes = $nextDiabetes;
                        $this->ids->nextbiometrics = $nextBiometrics;
                    }
                    
                    if ($this->ids->nextfitness == "L" && $this->ids->nextroutine == "L" && 
                        $this->ids->nextnutrition == "L" && $this->ids->nextsleep == "L" && 
                        $this->ids->nextweight == "L" && $this->ids->nextdiabetes == "L" && 
                        $this->ids->nextbiometrics == "L") {
                        
                        $this->ids->allDone = true;
                        $this->ids->nextfitness = "";
                        $this->ids->nextroutine = "";
                        $this->ids->nextnutrition = "";
                        $this->ids->nextsleep = "";
                        $this->ids->nextweight = "";
                        $this->ids->nextdiabetes = "";
                        $this->ids->nextbiometrics = "";
                    } else {
                        if ($this->ids->nextfitness == "L") {
                            $this->ids->allDone = true;
                        }
                        if ($this->ids->nextroutine == "L") {
                            $this->ids->allDone = true;
                        }
                        if ($this->ids->nextnutrition == "L") {
                            $this->ids->allDone = true;
                        }
                        if ($this->ids->nextsleep == "L") {
                            $this->ids->allDone = true;
                        }
                        if ($this->ids->nextsleep == "L") {
                            $this->ids->allDone = true;
                        }
                    }
                } else {
                    throw new \Exception($mysqli->error);
                }
            
                $stmt->close();
                $mysqli->close();
            }
        }
        
        function getActiviIds() {
            $nowDate = new \DateTime();
            $startDate = $nowDate->modify('-5 minutes');
           
            if ($this->ids->allDone) {
                print $this->ids->lastupdate->format('Y-m-d H:i:s');
                $startDate = $this->ids->lastupdate->modify('+1 seconds');
                print $startDate->format('Y-m-d H:i:s');;
            }
             /*
            if (i$this->ids->nextfitness != "L") {
                getValidicData(0, startDate, nowDate, "");
            }
            if ($this->ids->nextroutine != "L") {
                getValidicData(1, startDate, nowDate, "");
            }
            if ($this->ids->nextnutrition != "L") {
                getValidicData(2, startDate, nowDate, "");
            }
            if ($this->ids->nextsleep != "L") {
                getValidicData(3, startDate, nowDate, "");
            }
            if ($this->ids->nextweight != "L") {
                getValidicData(4, startDate, nowDate, "");
            }
            if ($this->ids->nextdiabetes != "L") {
                getValidicData(5, startDate, nowDate, "");
            }
            if ($this->ids->nextbiometrics != "L") {
                getValidicData(6, startDate, nowDate, "");
            }
            */
        }
    }

    /**
    * Model used to check if user activities have been done.
    *
    * @property string $nextFitness  
    * value (L) = Done
    * 
    * @property string $nextRoutine value (L) Done
    * value (L) = Done
    *
    * @property string $nextNutrition value (L) Done
    * value (L) = Done
    *
    * @property string $nextSleep value (L) Done
    * value (L) = Done
    *
    * @property string $nextWeight value (L) Done
    * value (L) = Done
    *
    * @property string $nextDiabetes value (L) Done
    * value (L) = Done
    *
    * @property string $nextBiometrics value (L) Done
    * value (L) = Done
    *
    * @property datetime $lastUpdate
    * Date update happens wehn all user activities are done
    *
    * @property bool $allDone
    * value (1) = Done all activities
    *
    */
    class Ids
    {
        public $nextFitness;
        public $nextRoutine;
        public $nextNutrition;
        public $nextSleep;
        public $nextWeight;
        public $nextDiabetes;
        public $nextBiometrics;
        public $lastUpdate;
        public $allDone;
    }
}
