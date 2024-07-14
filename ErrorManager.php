<?
class ErrorManager {

    var $errorCounter = Array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);

    var $errorMessage = '';
    var $errorEscape = '';
    var $errorLog = '';
    var $errorAlarme = '';

    var $errorTrackingLevel = 1;
    var $numberError = 0;
    var $maxErrorReport = 0;

    var $errorActived = true;
    var $errorManagerSystem = true;

    //Constructeur-----------------------------------------------------
    function ErrorManager($errorManagerSystem = '', $level = '', $escape = '', $query = '', $file = '', $alarme = ''){

        if ($errorManagerSystem) $this -> errorManagerSystem = $errorManagerSystem;
        elseif (defined('ERROR_MANAGER_SYSTEM')) {
            $this -> errorManagerSystem = ERROR_MANAGER;
            if ($this -> errorManagerSystem != 'off') $this -> errorManagerSystem = true;
            else $this -> errorManagerSystem = false;
            }

        if ($level) $this -> errorTrackingLevel = $level;
        elseif (defined('ERROR_MANAGER_LEVEL')) $this -> errorTrackingLevel = ERROR_MANAGER_LEVEL;

        if ($escape) $errorEscape = $escape.$query;
        elseif (defined('ERROR_MANAGER_ESCAPE')) $errorEscape = ERROR_MANAGER_ESCAPE.$query;
        if (is_file($errorEscape) || ereg('http://', $errorEscape)) $this -> errorEscape = $errorEscape;

        if ($alarme) $this -> errorAlarme = $alarme;
        elseif (defined('ERROR_MANAGER_ALARME')) $this -> errorAlarme = ERROR_MANAGER_ALARME;
        if (! ereg('(^(.+)@(.+)\.(.+)$[,;]?)+', $this -> errorAlarme)) unset($this -> errorAlarme);

        if ($file) $this -> errorLog = $file;
        elseif (defined('ERROR_MANAGER_LOG')) $this -> errorLog = ERROR_MANAGER_LOG;
        }

    //Paramétrage -----------------------------------------------------------

    function SetErrorLock($func){
        if (strtolower($func) == 'actived') $func = true;
        if (strtolower($func) == 'desactived') $func = false;

        $this -> errorActived = $func;
        return true;
        }

    function SetErrorOut($url){
        if (is_file($url) || ereg('http://', $url)) {
            $this -> errorEscape = $url;
            return true;
            }
        else return false;
        }

    //Gestionnaire -----------------------------------------------------------

    function ErrorTracker($warning, $message, $func = '', $file = '', $line = ''){
        switch ($warning){
            case 1:
                $type = "Low warning";
                break;
            case 2:
                $type = "Warning";
                break;
            case 3:
                $type = "Notification";
                break;
            case 4:
                $type = "Error";
                break;
            case 5:
                $type = "Emergency break";
                break;
            default:
                $type = "Unknown error";
                $warning = 0;
            }

        $this -> numberError ++;
        if (++ $this -> errorCounter[$warning] > 0 && $warning > $this -> maxErrorReport) $this -> maxErrorReport = $warning;

        if ($this -> numberError > 1) $pre = "\t<li>";
        else $pre = "\n<ul>\n\t<li>";

        $this -> errorMessage .= $pre.$type.' no '.$this -> errorCounter[$warning].' ';

        if ($func) $this -> errorMessage .= 'on <b>'.$func.'</b> ';
        if ($file) $this -> errorMessage .= 'in file <b>'.$file.'</b> ';
        if ($line) $this -> errorMessage .= 'on line <b>'.$line.'</b> ';

        $this -> errorMessage .= ': <i>'.$message.'</i><br>'."\n";
        $this -> ErrorChecker();
        }


    function ErrorChecker($level = ''){
        if ($level == '') $level = $this -> errorTrackingLevel;

        if ($this -> maxErrorReport >= $level) {
            $message = 'The '.date('<b>d/M/Y </b> H:i:s')."<br />\n".'ErrorManager report, you\'ve got '.$this -> numberError.' error(s), see below to correct:'."\n<br>\n".$this -> errorMessage."\n</ul>";

            if ($this -> errorAlarm) @mail('ErrorManager', $this -> errorAlarm, '[ErrorManager][Alarm]', $message);
            if ($this -> errorLog) {
                $ouv = @fopen($this -> errorLog, 'a');
                @fputs($ouv, $message);
                @fclose($ouv);
                }
            if ($this -> errorActived) {
                if ($this -> errorEscape) header('location: '.$this -> errorEscape);
                else {
                    print($message);
                    exit;
                    }
                }
            else {
                if (strtoupper($level) == 'GET') return $message;
                else return false;
                }
            }
        else return true;
        }
    }
?>