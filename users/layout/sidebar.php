<!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">

        <div class="brand-logo">
            <a href="index.php">
                <!-- <img src="../assets/images/logo-icon.png" class="logo-icon" alt="logo icon"> -->
                <!-- <h5 class="logo-text">TEIPI CMS</h5> -->
                <img src="../assets/images/Tsukiden_Transparent_White.png" style="width:200px;" alt="logo icon">
            </a>
        </div><br>
        
        <ul class="sidebar-menu do-nicescrol">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="index.php">
                    <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="pos.php">
                    <i class="fa-solid fa-tv"></i> <span>POS</span>
                </a>
            </li>

            <li>
                <a href="items.php">
                    <i class="fa-solid fa-rectangle-list"></i> <span>Items</span>
                    <!-- <button type="button" class="btn btn-outline-success">+</button> -->
                </a>
            </li>

            <li>
                <a href="categories.php">
                    <i class="fa-solid fa-book"></i> <span>Categories</span>
                    <!-- <button type="button" class="btn btn-outline-success">+</button> -->
                </a>
            </li>

            <li>
                <a href="employee_trans.php">
                    <i class="fa-solid fa-clipboard-list"></i> <span>Transactions</span>
                </a>
            </li>

            <li>
                <a onclick="sdbrItems('sdbr_dd2')">
                    <i class="fa-solid fa-print"></i> <span>Reports</span>
                </a>
            </li>
                <ul class="list-unstyled sdbr-sub-item" style="display:none" id="sdbr_dd2">
                    <!-- <li>
                        <a href="#">
                            <span>Transactions</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="discounts.php">
                            <span>Discounts</span>
                        </a>
                    </li>
                    <li>
                        <a href="credits_trans.php">
                            <span>Cash \ Credits</span>
                        </a>
                    </li>
                    <li>
                        <a href="orders_summary.php">
                            <span>Orders Summary</span>
                        </a>
                    </li>
                </ul>

            <li class="sidebar-header">SHORTCUTS</li>
            <li><a href="front_display.php" target="_blank"><i class="fa-solid fa-tv"></i>POS Display</span></a></li>

            <?php

                if($_COOKIE["CMS_usrlevel"] == 1){

                    ?>

                        <li><a href="settings.php"><i class="fa-solid fa-cog"></i> <span>Settings</span></a></li>

                    <?php
                }
            ?>

            <li><a href="includes/logout.php"><i class="fa-solid fa-power-off text-danger"></i> <span>Log Out</span></a></li>
            <!-- <li><a href="javaScript:void();"><i class="fa-solid fa-triangle-exclamation text-warning"></i> <span>Warning</span></a></li>
            <li><a href="javaScript:void();"><i class="fa-solid fa-circle-info text-info"></i> <span>Information</span></a></li> -->

        </ul>
    
    </div>
<!--End sidebar-wrapper-->