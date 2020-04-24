<?php
$message = new Message();
$message = $message->getAllComments($_SESSION['ticket']->id_ticket);

foreach ($message as $item) {
    echo '<div class="message_users">
			<div class="message_users_pole">
			<p class="message_users_login">'. $item->login_user . '</p>
			<p class="message_users_date">' . $item->dateMessage . '</p>
			<textarea name="text_message" maxlength=350 rows="5" id="text_message" 
					class="message_users_textarea-redacted" readonly>' . $item->textMessage . '</textarea>
			</div>			
		</div>';
}
