<?php

/**
 * Blockchain Concept 
 * Muffincoin
 * 
 * @author Ugur Cengiz <ugurcengiz@mail.com.tr>
 */

$blockchain = [];

Blockchain::addBlock($blockchain, new Transaction('533D9981', '489982e1', 2, time()));
Blockchain::addBlock($blockchain, new Transaction('489982e1', '533D9981', 1, time()));
Blockchain::addBlock($blockchain, new Transaction('71520034', '41973521', 12, time()));
Blockchain::addBlock($blockchain, new Transaction('48520068', 'T84F9652', 4, time()));

//$blockchain[2]->amount = 22;

if (Blockchain::validateBlockChain($blockchain)) {
    echo 'Blockchain confirmed.';
} else {
    echo 'Blockchain is not confirmed!';
}


class Transaction
{
    public $sender;
    public $reciever;
    public $amount;
    public $timestamp;
    public $hash;

    /**
     * Transaction
     */
    public function __construct($sender, $reciever, $amount, $timestamp)
    {
        $this->sender = $sender;
        $this->reciever = $reciever;
        $this->amount = $amount;
        $this->timestamp = $timestamp;
        $this->hash = md5($sender . $reciever . $amount . $timestamp);
    }

}

class Blockchain
{

    public static function addBlock(&$blockchain, $transaction)
    {

        if (count($blockchain) > 0) {
            $lastBlockChainIndex = count($blockchain) - 1;
            $transaction->previousHash = $blockchain[$lastBlockChainIndex]->hash;
        }

        $blockchain[] = $transaction;
    }

    public static function validateBlockChain($blockchain)
    {
        $blockChainBroke = false;

        //Let's validate blockchain
        foreach ($blockchain as $index => $chain) {
            if (isset($chain->previousHash)) {
                $previousHash = md5($blockchain[$index - 1]->sender . $blockchain[$index - 1]->reciever . $blockchain[$index - 1]->amount . $blockchain[$index - 1]->timestamp);
                if ($chain->previousHash != $previousHash) {
                    $blockChainBroke = true;
                }
            }
        }

        //If blockchain is not broke, returns true
        if (!$blockChainBroke) {
            return true;
        }
    }
}


?>