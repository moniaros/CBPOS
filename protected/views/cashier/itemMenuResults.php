<div class="shopp">
<?php
while ($menuItemsResult = mysql_fetch_assoc($rsd))
{?>
    <div class="grumpy-image">
            <?php
                echo TbHtml::label($menuItemsResult['menu_item_name'], "", array(
                    'onclick'=>'displayMenu("'.$menuItemsResult['menu_item_name'].'", "'.
                                               $menuItemsResult['menu_item_price'].'", "'.
                                               $menuItemsResult['menu_item_id'].'");',
                    'data-toggle' => 'modal',
                    'data-target' => '#myModal',
                    'style' => 'height:120px; width:180px; cursor: pointer;
                        font-size: 25px;text-wrap: normal;background-color: blue;
                        background-color: #FFD324;padding-top: 10px;',
                ));
                echo '&nbsp&nbsp';
            ?>
    </div>
<?php
}?>
    	</div>
<script type="text/javascript">
$(document).ready(function(){
	
	var Timer  = '';
	var selecter = 0;
	var Main =0;
	
	bring(selecter);
	
});

function bring ( selecter )
{	
	$('div.shopp:eq(' + selecter + ')').stop().animate({
		opacity  : '1.0',
		height: '300px',
                padding: '10px'
		
	},300,function(){
		
		if(selecter < 6)
		{
			clearTimeout(Timer); 
		}
	});
	
	selecter++;
	var Func = function(){ bring(selecter); };
	Timer = setTimeout(Func, 20);
}
</script>