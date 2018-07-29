        <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <?php 
                        
                            if(isset($_SESSION['admin_logged_in'])){
                                
                                echo '<li>
                                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                </li>';
                            }
                              
                        ?>
                        
                        
                         <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <!-- <li>
                                    <a href="flot.php">Flot Charts</a>
                                </li>-->

                                <li>
                                    <a href="morris.php">Analytics</a>
                                </li>

                            </ul>
                           <!--/.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.php"><i class="fa fa-table fa-fw"></i> Big Data</a>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-edit fa-fw"></i> Admin Forms<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <!-- <li>
                                    <a href="flot.php">Flot Charts</a>
                                </li>-->
                            <?php 
                                if(isset($_SESSION['admin_logged_in'])){

                                    echo '<li>
                                        <a href="adduser.php">Add Admin User</a>
                                    </li>';
                                }
                              
                            ?>
                                <li>
                                    <a href="addproduct.php">Add Product</a>
                                </li>

                            </ul>
                           <!--/.nav-second-level -->
                            
                        </li>
              
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav> 