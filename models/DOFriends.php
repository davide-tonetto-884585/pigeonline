<?php
namespace models;

class DOFriends{

    private $userId;
    private $friendId;
	private $authorizated;
	private $lastModify;

    public function __construct($userId = null, $friendId = null, $authorizated = null, $lastModify = null)
    {
        if (func_get_args() != null) {
            $this->userId = $userId;
            $this->friendId = $friendId;
			$this->authorizated = $authorizated;
			$this->lastModify = $lastModify;
        }
    }

	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($userId){
		$this->userId = $userId;
	}

	public function getFriendId(){
		return $this->friendId;
	}

	public function setFriendId($friendId){
		$this->friendId = $friendId;
	}

	public function getAuthorizated(){
		return $this->authorizated;
	}

	public function setAuthorizated($authorizated){
		$this->authorizated = $authorizated;
	}

	public function getLastModify(){
		return $this->lastModify;
	}

	public function setLastModify($lastModify){
		$this->lastModify = $lastModify;
	}
}

?>