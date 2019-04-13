<?php
/**
 * Created by PhpStorm.
 * User: dmitrymolokovich
 * Date: 2019-04-13
 * Time: 17:57
 */

namespace ColorText;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class colorText extends PluginBase implements Listener
{
    private $colors = [C::BLUE, C::GREEN, C::DARK_PURPLE, C::RED, C::DARK_RED]; // you can add more colors
    private $last = null; // saved value, this var uses to non-repeating colors

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    private function rand($string) { // $string uses to count letters in your word
        $array = $this->colors;
        $lenth = strlen($string);
        for ($i = 0; $i <=  $lenth - 1; $i ++) {
            $rand = $array[array_rand($array)];
            while ($this->last == $rand) {
                $rand = $array[array_rand($array)];
            }
            $this->last = $rand;
            return $this->last;
        }
    }
/* function colorText uses rand function to color the text by letters **/
    private function colorText ($string) { // $string uses to color your word or words!
        $stringByLetter = str_split($string); // disassemble your word or words
        $correct = ""; // final word
        foreach ($stringByLetter as $value) { // iterating over the array of letters
            $letter = $this->rand($string) . $value;
            $correct = $correct . $letter;
        }
        return $correct;
    }
    public function onJoin(PlayerJoinEvent $event) {
        $event->getPlayer()->sendTip($this->colorText("Welcome" . " " . $event->getPlayer()->getName()));
    }
}