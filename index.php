<?php
    $ibtitle = 'หน้าแรก';
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
          if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
          $page_count = $data_setting_fatch['animecount'];
          $start_page = ($page-1) * $page_count;
    $str = 'SELECT * FROM ib_fansub_anime LEFT JOIN ib_fansub_project ON ib_fansub_anime.pid=ib_fansub_project.pid LEFT JOIN ib_fansub_season ON ib_fansub_project.sid=ib_fansub_season.sid ORDER BY ib_fansub_anime.lastdate DESC LIMIT '.$start_page.', '.$page_count;
    $anquery = mysqli_query($conn, $str);
    
    //TOPIC
    $topic = mysqli_query($conn, "SELECT * FROM ib_fansub_topic ORDER BY date DESC LIMIT 5");
?>
<div class="container">
    <div class="row">
        <?php if($data_setting_fatch['siteanno']=='1'){ ?>
        <div class="col-sm-12" style="margin-top: 30px;">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-sm-1"><div class="ib-anno">ประกาศ : </div></div>
                        <div class="col-sm-11">                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <p><span style="font-size:14px"><?php echo $data_setting_fatch['siteanno_text'];?></span></p>
                    </marquee></div>
                                           
                    </div>

                </div>
        </div>
        <?php } ?>
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 20px !important;">
                <h4>New Releases</h4>
            </div>
            <?php if($data_setting_fatch['animeshow']==0){
                    include 'include/anime_type_list.php';
            }else{
                    include 'include/anime_type_grid.php';
            } ?>
            <?php echo pagination($conn,$page_count,$page,$url='index.php?mod=index&page=',$queryPage="SELECT COUNT(aid) FROM ib_fansub_anime"); ?>
            </div>
            <div class="col-sm-4 col-xs-12">
            <div class="page-header" style="margin-top: 20px !important;">
                <h4>Announcements</h4>
            </div>
            <div class="list-group">
            <?php while ($tp = mysqli_fetch_array($topic)){ ?>
              <div class="list-group-item">
                  <a class="ib-link" href="topic.php?mod=read&tid=<?=$tp['tid'];?>"><?=$tp['topic'];?></a>
              </div>
            <?php } ?>
            </div>
            <?php include 'template/'.$data_setting_fatch['sitetheme'].'/side.php'; ?>
        </div>
    </div>    
</div>
<?php
    include 'template/'.$data_setting_fatch['sitetheme'].'/footer.php';
?>