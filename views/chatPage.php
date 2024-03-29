<!DOCTYPE html>
<html>

<head>
    <title>PigeOnLine</title>
    <?php require_once('./utils/includeHead.php'); ?>

    <link href="utils/css/menu.css" rel="stylesheet">
    <link href="utils/css/chat.css" rel="stylesheet">
</head>

<body style="background-color: #7c7e83">
    <!-- #bfbfbf  -  #b3b3b3  -  #a6a6a6 -->
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#" style="z-index: 10">
            <i class="fas fa-bars"></i>
        </a>
        <?php
        require_once('./views/menu.php')
        ?>

        <main class="page-content">
            <div class="messaging" style="padding: 0;">

                <?php
                if ($chat->getChatType() == '1' || $chat->getChatType() == '4') {
                    $otherUser = ($chatMembers[0]['userId'] !== $_SESSION['id']) ? $chatMembers[0] : $chatMembers[1];
                    echo '<div class="outgoing_usr" style="height: 52px; background-color: #dddddd">
                                <div style="height: 50px; padding: 2px 2px 2px 2px;">
                                    <img id="imgChatPageTopBanner" style="width: 48px; height: 48px;" class="chat-img fa-pull-left" src="' . $otherUser['pathProfilePicture'] . '" alt="Avatar">
                                    <span id="nameChatPageTopBanner" style="padding-left: 10px; font-size: large; color: Black; height: 25px; display: inline-block;">' . $otherUser['username'] . '</span>';
                    if ($otherUser['privacyLevel'] != '3') {
                        $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
                        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
                        echo '<br><span id="onOffChatPageTopBanner" class="span-group-members" style="padding-left: 10px; font-size: smaller">';
                        echo ($otherUser['lastActivity'] > $current_timestamp) ? 'Online</span>' : 'Offline</span>';
                    }
                    echo        '</div>
                                <button id="chatDetails" style="right: 15px;" class="msg_send_btn" type="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                            </div>';
                } else {
                    if ($chat->getChatType() != '5') {
                        $groupMembers = '';
                        for ($i = 0; $i < count($chatMembers); $i++) {
                            $groupMembers .= $chatMembers[$i]['username'];
                            if ($i < count($chatMembers) - 1)
                                $groupMembers .= ', ';
                        }
                    } else {
                        $groupMembers = "messaggi salvati di " . $user->getUsername();
                    }
                    echo '<div class="outgoing_usr" style="height: 52px; background-color: #dddddd">
                                <div style="height: 50px; padding: 2px 2px 2px 2px;">
                                    <img id="imgChatPageTopBanner" style="width: 48px; height: 48px;" class="chat-img fa-pull-left" src="' . $chat->getPathToChatPhoto() . '" alt="Avatar">
                                    <span id="nameChatPageTopBanner" style="padding-left: 10px; font-size: large; color: Black; height: 25px; display: inline-block;">' . $chat->getTitle() . '</span>
                                    <br><span class="span-group-members">' . $groupMembers . '</span>
                                </div>
                                <button id="chatDetails" style="right: 15px;" class="msg_send_btn" type="button"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                            </div>';
                }
                ?>

                <div class="msg_history" id="messaggi">
                    <?php
                    if (!is_null($messages)) {
                        include('./views/newMessages.php');
                        echo '<div style="width: 100%" class="received_withd_msg">
                                    <p style="margin: auto; color: white; background: #31353d none repeat scroll 0 0;margin-bottom: 5px;">Nuovi messaggi</p>
                                </div>';
                    } else {
                        echo '<div style="width: 100%" class="received_withd_msg">
                                    <p style="margin: auto; color: white; background: #31353d none repeat scroll 0 0;margin-bottom: 5px;">Inizio messaggi</p>
                                </div>';
                    }

                    ?>

                    <div id="newMessages"></div>

                </div>
                <div class="type_msg">
                    <div class="input_msg_write" style="background: #ddd;">
                        <?php
                        if (isset($chatMember) && $chatMember->getUserType() == '1') {
                            echo '<input style="text-align:center;" placeholder="Non puoi scrivere qui!" disabled/>';
                        } else {
                        ?>
                            <form class="wrapper" action="" method="POST" enctype="multipart/form-data" id="formSendMessage">
                                <input autocomplete="off" style="padding-left: 15px; padding-right: 100px" type="text" class="write_msg" name="messageText" id="messageText" placeholder="Type a message" />
                                <?php if($chat->getChatType() != '4') { //disabilito invio file nell chat segrete, da implementare successivamente ?>
                                <div style="position: absolute;right: 62px;bottom: 4px;border-radius: 50%;background: #05728f none repeat scroll 0 0;margin: 0" class="fileUpload btn btn-primary">
                                    <i class="fas fa-paperclip"></i>
                                    <input name="file" id="uploadFileInChat" type="file" class="upload" />
                                </div>
                                <?php } ?>
                                <!-- <button class="msg_send_btn" style="right: 55px;" type="button"><i class="fa fa-paperclip" aria-hidden="true"></i></button> -->
                                <button id="BTNSendMessage" type="submit" class="msg_send_btn" style="right: 20px;" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>

            </div>

        </main>

        <div id="rightMenu"></div>

    </div>

    <div id="modal"></div>
    <?php
    require_once('./views/modalSendFile.php');
    ?>
    <!-- right click menu -->
    <div style="padding: 0" class="dropdown-menu dropdown-menu-sm" id="context-menu">
        <a class="dropdown-item" href="#">Copy</a>
        <a class="dropdown-item" href="#">Delete</a>
        <a class="dropdown-item" href="#">Modify</a>
        <a class="dropdown-item" href="#">Pin</a>
        <a class="dropdown-item" href="#">Quote</a>
        <a class="dropdown-item" href="#">Forwards</a>
    </div>

    <!-- CONTENUTO DELLA PAGINA  -->

    <!-- JS -->

    <?php require_once('./utils/includeBody.php'); ?>
    <script src="./utils/js/menu.js"></script>
    <script src="./utils/js/chat.js"></script>
    <script src="./utils/js/message.js"></script>

    <script>
        $("#messaggi").animate({
            scrollTop: $('#messaggi').prop("scrollHeight")
        }, 0);
    </script>

    <!-- JS -->
</body>

</html>