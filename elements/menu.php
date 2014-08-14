 <?php
 	require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/config.php';
 ?>
          	<div class="header">
                <div class="logo"><a href="index.html"><img src="/flower_shop/images/logo.gif" alt="" title="" border="0" /></a></div>
                <div id="menu">
                    <ul>
                        <li name="menu0"><a href=<?php echo "\"" . MACHINE_NAME ."/flower_shop/index.php\""?>><?php echo date("Y-m-d",strtotime("+0 day"))?></a></li>
                        <li name="menu1"><a href=<?php echo "\"" . MACHINE_NAME ."/flower_shop/index.php?page=1\""?>><?php echo date("Y-m-d",strtotime("+1 day"))?></a></li>
                        <li name="menu2"><a href=<?php echo "\"" . MACHINE_NAME ."/flower_shop/index.php?page=2\""?>><?php echo date("Y-m-d",strtotime("+2 day"))?></a></li>
                        <li name="menu3"><a href=<?php echo "\"" . MACHINE_NAME ."/flower_shop/index.php?page=3\""?>><?php echo date("Y-m-d",strtotime("+3 day"))?></a></li>
                        <li name="menu4"><a href=<?php echo "\"" . MACHINE_NAME ."/flower_shop/index.php?page=4\""?>><?php echo date("Y-m-d",strtotime("+4 day"))?></a></li>
                        <li name="menu5"><a href=<?php echo "\"" . MACHINE_NAME ."/flower_shop/index.php?page=5\""?>><?php echo date("Y-m-d",strtotime("+5 day"))?></a></li>
                    </ul>
                </div>

            </div>