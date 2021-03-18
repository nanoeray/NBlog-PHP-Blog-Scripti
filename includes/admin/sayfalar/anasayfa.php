<?php

$gun = date("d") - 7;
$ilk = "-".$gun;
$son = date("Y-m").$ilk." ".date("H:i:s");
$yeniYorumSql = mysql_query("SELECT * FROM blog_yorumlar WHERE tarih >='".$son."'");
$yeniYorum = mysql_num_rows($yeniYorumSql);

$destekSql = mysql_query("SELECT * FROM destek_sistemi WHERE durum=0");
$destekTalebi = mysql_num_rows($destekSql);

$yeniUrunSql = mysql_query("SELECT * FROM uye_urunleri WHERE durum='0' ORDER by alimTarihi DESC");
$yeniUrun = mysql_num_rows($yeniUrunSql);

echo '
<div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Yönetim Paneli</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$yeniYorum.'</div>
                                    <div style="width: 180px;text-align: left;margin-left: -8px;margin-top: 3px;">Son 7 günde atılan Yorum</div>
                                </div>
                            </div>
                        </div>
                        <a href="?admin=blogs">
                            <div class="panel-footer">
                                <span class="pull-left">Detaylara Git</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">0</div>
                                    <div>Güncelleme Mevcut!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Detaylara Git</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$yeniUrun.'</div>
                                    <div>Yeni Ürün Beklemede!</div>
                                </div>
                            </div>
                        </div>
                        <a href="index.php?admin=uye_urunler">
                            <div class="panel-footer">
                                <span class="pull-left">Detaylara Git</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$destekTalebi.'</div>
                                    <div>Destek Talebi Mevcut!</div>
                                </div>
                            </div>
                        </div>
                        <a href="index.php?admin=destek">
                            <div class="panel-footer">
                                <span class="pull-left">Detaylara Git</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->';

?>