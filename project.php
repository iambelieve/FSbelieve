<?php
    include 'config/title.php';
    $navtitle = mysqli_fetch_array(mysqli_query($titleconn, "SELECT title FROM ib_fansub_project WHERE pid = ".$_GET['pid']));
    $ibtitle = 'Project - '.$navtitle['title'];
    include 'include/header_common.php';
    include 'template/'.$data_setting_fatch['sitetheme'].'/header.php';
    $project = mysqli_query($conn, "SELECT * FROM ib_fansub_project LEFT JOIN ib_fansub_season ON ib_fansub_project.sid=ib_fansub_season.sid WHERE ib_fansub_project.pid = ".$_GET['pid']);
    $pj = mysqli_fetch_array($project);
    mysqli_query($conn, "UPDATE ib_fansub_project SET pjviews = pjviews+1 WHERE pid = ".$_GET['pid']);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4><?=$pj['title'];?> <div class="label label-primary ib-label"><?php echo (($pj['onair']=='1')?'OnGoing':'Complete');?></div><div class="pull-right"><h6>เข้าชม <?=($pj['pjviews']+1);?></h6></div></h4>
            </div>
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                    <img src="<?=$pj['thumbnail'];?>" />
                </a>
              </div>
              <div class="col-xs-6 col-md-9">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#story" data-toggle="tab" aria-expanded="true">Summary</a></li>
                      <li class=""><a href="#info" data-toggle="tab" aria-expanded="false">Project Info</a></li>
                      <?php if($pj['trailer']!=''){?>
                      <li class=""><a href="#trailer" data-toggle="tab" aria-expanded="false">Trailer</a></li>
                      <?php }?>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane fade active in" id="story" style="height: 180px; overflow-y: scroll;">
                        <div class="well well-sm well-ib" >
                            <?=$pj['summary'];?>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="info" style="height: 180px; overflow-y: scroll;">
                          <?php $pjdata = json_decode($pj['data_json'],TRUE); ?>
                          <?php if($pj['co_work']!=''){?><p>Co-work : <?=$pj['co_work'];?></p><?php } ?>
                          <p>Translator : <?=$pjdata['translator'];?></p>
                          <p>QC : <?=$pjdata['qc'];?></p>
                          <p>Encode : <?=$pjdata['encode'];?></p>
                          <p>Upload : <?=$pjdata['upload'];?></p>
                          <p>Artwork/Intro : <?=$pjdata['artwork'];?></p>
                          <p>Karaoke Effect : <?=$pjdata['kara'];?></p>
                      </div>
                        <?php if($pj['trailer']!=''){?>
                      <div class="tab-pane fade" id="trailer">
                        <iframe width="100%" height="180" src="https://www.youtube.com/embed/<?=$pj['trailer'];?>" frameborder="0" allowfullscreen></iframe>
                      </div>
                        <?php }?>
                    </div>
              </div>
            </div>
            <table class="table table-striped table-hover ">
                <thead>
                  <tr>
                    <th width="65%">Anime - Episode</th>
                    <th>Online</th>
                    <th>Download</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $anime = mysqli_query($conn, "SELECT * FROM ib_fansub_anime LEFT JOIN ib_fansub_project ON ib_fansub_anime.pid=ib_fansub_project.pid WHERE ib_fansub_anime.pid = '".$pj['pid']."' ORDER BY ib_fansub_anime.date ASC");
                    $lk = mysqli_query($conn, "SELECT * FROM ib_fansub_download WHERE link_d_active = 1 AND link_active = 1");
                    while ($a = mysqli_fetch_array($anime)){
                ?>
                  <tr>
                    <td><h5><?=$a['title']." - ".$a['episode'];?></h5></td>
                    <td><a href="watch.php?vid=<?=$a['vid'];?>" class="btn btn-default">Watch</a></td>
                    <td><div class="btn-group">
                        <a onclick="getlink('<?=$a['gdrive'];?>','<?=$a['vid'];?>','<?=$a['episode'];?>','<?=$a['title'];?>');" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Download <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <?php echo (($a['gdrive'])?'<li><a href="https://docs.google.com/a/kimochii-jp.net/uc?id='.$a['gdrive'].'&export=download" target="_blank">Google Drive</a></li>':'');
                            $linkjs = json_decode($a['linkcontent'],TRUE);
                            while ($link = mysqli_fetch_array($lk)) {
                              echo (($linkjs[$link['link_title']])?'<li><a href="'.$linkjs[$link['link_title']].'" target="_blank">'.$link['link_title'].'</a></li>':''); 
                            } ?>
                          <li class="divider"></li>
                          <li id="<?=$a['vid'];?>"><a href="#">Processing..</a></li>
                        </ul>
                    </div></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table> 
            <div class="well well-sm well-ib">
                GENRE : <br>
                <?php 
                    $genrefet = mysqli_query($conn, "SELECT * FROM ib_fansub_anime_genre WHERE aid = '".$pj['pid']."'");
                    while ($grf = mysqli_fetch_array($genrefet)){ 
                    $genrename = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ib_fansub_genre WHERE genreid = '".$grf['genreid']."'"));
                    ?>
                <a href="#"><span class="label label-primary"><?=$genrename['genre'];?></span></a>
                    <?php } ?>
            </div>
            </div>
            <div class="col-sm-4 col-xs-12">
            <div class="page-header" style="margin-top: 40px !important;">
                <h4>Season Anime</h4>
            </div>
            <div class="list-group">
           <?php $project_recent = mysqli_query($conn, "SELECT * FROM ib_fansub_project WHERE sid = '".$pj['sid']."' ORDER BY rand() LIMIT 7");
           while ($p = mysqli_fetch_array($project_recent)){?>
              <div class="list-group-item">
                  <a class="ib-link" href="project.php?pid=<?=$p['pid'];?>"><?=$p['title'];?></a>
              </div>
           <?php } ?>
            </div>
                <?php include 'template/'.$data_setting_fatch['sitetheme'].'/side.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getlink(gid,vid,ep,title){
        jq.get("http://api.iam-believe.xyz/drive/"+gid,function(data){
            if(data['link360']){
                var link360 = '<a href="'+ data['link360'] +'&title='+title+' - '+ep+'" download>360p</a>';
            }else{var link360 = '';}
            if(data['link480']){
                var link480 = '<a href="'+ data['link480'] +'&title='+title+' - '+ep+'" download>480p</a>';
            }else{var link480 = '';}
            if(data['link720']){
                var link720 = '<a href="'+ data['link720'] +'&title='+title+' - '+ep+'" download>720p</a>';
            }else{var link720 = '';}
            if(data['link1080']){
                var link1080 = '<a href="'+ data['link1080'] +'&title='+title+' - '+ep+'" download>1080p</a>';
            }else{var link1080 = '';}
            var link = link360+link480+link720+link1080;
            jq( '#'+vid ).html(link);
	},"json");
    }
</script>
<?php
    include 'template/'.$data_setting_fatch['sitetheme'].'/footer.php';
?>

