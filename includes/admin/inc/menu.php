<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">NBlog Kss v2.0 Yönetim Paneli</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="index.php?admin=ayarlar"><i class="fa fa-user fa-fw"></i> Site Ayarları</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Çıkış</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a  href="index.php" class="<?php if(@$_GET['admin'] == '') echo 'active'; ?>"><i class="fa fa-dashboard fa-fw"></i> Anasayfa</a>
                        </li>
                        <li>
                            <a href="index.php?admin=blogs" class="<?php if(@$_GET['admin'] == 'blogs') echo 'active'; ?>" ><i class="fa fa-table fa-fw"></i> Blog</a>
                        </li>
						<li>
                            <a href="index.php?admin=kategoriler" class="<?php if(@$_GET['admin'] == 'kategoriler') echo 'active'; ?>"><i class="fa fa-sitemap fa-fw"></i> Kategoriler</a>
                        </li>
                        <li>
                            <a href="index.php?admin=projeler" class="<?php if(@$_GET['admin'] == 'projeler') echo 'active'; ?>"><i class="fa fa-edit fa-fw"></i> Projeler</a>
                        </li>
						 <li>
                            <a href="index.php?admin=destek" class="<?php if(@$_GET['admin'] == 'destek') echo 'active'; ?>"><i class="fa fa-edit fa-fw"></i> Destek Talepleri</a>
                        </li>
						<li>
                            <a href="index.php?admin=urunler" class="<?php if(@$_GET['admin'] == 'urunler') echo 'active'; ?>"><i class="fa fa-sitemap fa-fw"></i> Ürün Yönetim</a>
                        </li>
						<li>
                            <a href="index.php?admin=uye_urunler" class="<?php if(@$_GET['admin'] == 'uye_urunler') echo 'active'; ?>"><i class="fa fa-files-o fa-fw"></i> Üye Ürün Yönetim</a>
                        </li>
                    </ul>
					<center style="font-weight: bolder;">
					<br>
					NBlog V2.0 Yönetim Paneli<br>
					Copyright &copy; 2009-2014<br>
					Eray Tuğrul Gül<br>
					İsmail Gül</center>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>