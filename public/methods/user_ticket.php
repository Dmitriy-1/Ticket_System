<?php
global $data;

if(count($data)==0){
    echo '
        <div class="form_create_tic">
                <h1 class="form_create_tic_heading">Привествуем вас в нашей системе тикетов!!!</h1>
                <h3 class="form_create_tic_cont"> Мы проверили вас. У вас нет вопросов? </h3>
                <h3 class="form_create_tic_cont">Если есть создайте тикет и задайте их нам, а мы поможем вам!</h3>  
        </div>
        
    ';
    include('create_ticket_button.php') ;
}
else{
    for ($i = 0; $i < count($data); $i++) {
              echo '<div class="ticket_content_bd">
				<div class="ticket_content_bd_list">
						<h1 class="ticket_content_title"> Тема тикета</h1>
			            <a href="Page_ticket.php? id_ticket='.$data[$i]['id_ticket'].'" > <li class="ticket_content_li">' . $data[$i]['topic_ticket'] . '</li>     </a>        
					    <h1 class="ticket_content_title"> Статус тикета</h1>
					    <li class="ticket_content_li"> ' . $data[$i]['status_ticket'] . '</li>
					    <h1 class="ticket_content_title"> Имя создателя тикета</h1>
					    <li class="ticket_content_li"> ' . $data[$i]['login_user'] . '</li>
					    <h1 class="ticket_content_title"> Имя сотрудника техподдержки</h1>
			            <li class="ticket_content_li"> ' . $data[$i]['login_admin'] . '</li>
			</div>		
		</div>';
    }
    include('create_ticket_button.php') ;
}
