<?php

namespace models;

class DOChatMembers  
{
    private $userId;
    private $chatId;
    private $draft;
    private $userType;
    private $isTyping;

    public function __construct($userId = NULL, $chatId = NULL, $draft = NULL, $userType = NULL, $isTyping = NULL){
        if(func_get_args() != null) {
            $this->userId = $userId;
            $this->chatId = $chatId;
            $this->draft = $draft;
            $this->userType = $userType;
            $this->isTyping = $isTyping;
        }
    }

    public function getUserId(){
		return $this->userId;
	}

	public function setUserId($userId){
		$this->userId = $userId;
	}

	public function getChatId(){
		return $this->chatId;
	}

	public function setChatId($chatId){
		$this->chatId = $chatId;
	}

	public function getDraft(){
		return $this->draft;
	}

	public function setDraft($draft){
		$this->draft = $draft;
	}

	public function getUserType(){
		return $this->userType;
	}

	public function setUserType($userType){
		$this->userType = $userType;
	}

	public function getIsTyping(){
		return $this->isTyping;
	}

	public function setIsTyping($isTyping){
		$this->isTyping = $isTyping;
	}
}
