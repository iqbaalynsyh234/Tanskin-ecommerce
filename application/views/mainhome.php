<section id="content" style="padding-top: 110px;">
<div class="container">
<div id="carousel-slide-home" class="carousel carousel-fade slide slide-home" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php foreach ($banner as $key => $value) { ?>
      <li data-target="#carousel-slide-home" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>"></li>
    <?php } ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner full-view" role="listbox">
    <?php foreach ($banner as $key => $value) { ?>
      <div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
      <a href="<?php echo (!empty($value['url'])) ? $value['url'] : '#'; ?>">
        <div>
        <img src="<?php echo base_url('assets/image/slideshow/'.$value['image']); ?>" class="img-responsive">
        </div>
      </a>
      </div>
    <?php } ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-slide-home" role="button" data-slide="prev">
    <span class="control-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-slide-home" role="button" data-slide="next">
    <span class="control-chevron-right"></span>
  </a>
</div>
</div>
</section>


<div class="container pt-5">
  <div>
    <div class="row mb-5 align-items-center">
        <div class="col-md-4 col-pad">
          <div class="wrap-img">
            <img class="w-100" src="<?php echo base_url('assets/image/slideshow/'.$home_image1['image']) ?>">
          </div>
        </div>
        <div class="col-md-4">
          <div class="wrap-text">
            <h4 class="text-title text-center"><?php echo $home_skin['section'] ?></h4>
            <?php echo $home_skin['deskripsi'] ?>          
          </div>
        </div>
        <div class="col-md-4">
          <div class="wrap-img">
            <img class="w-100" src="<?php echo base_url('assets/image/slideshow/'.$home_image2['image']) ?>">
          </div>
        </div>
      </div>
  </div>
</div>

<div class="container">
  <div class="row row_sm">
    <div class="col-md-6 col_sm">
    <div id="catalog-slider" class="carousel carousel-fade slide slide-home" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php if(count($slide_left) > 2){ foreach ($slide_left as $key => $value) { ?>
          <li data-target="#catalog-slider" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>"></li>
        <?php } } ?>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner full-view" role="listbox">
        <?php foreach ($slide_left as $key => $value) { ?>
          <div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
            <?php if($value['type'] == '1'){ ?>
            <a href="<?php echo (!empty($value['link'])) ? $value['link'] : '#'; ?>">
              <img src="<?php echo base_url('assets/image/slideshow/'.$value['image']) ?>" class="img-responsive" alt="<?php echo $value['name'] ?>">
            </a>
            <?php } else { ?>
              <iframe class="ivideo" src="https://www.youtube.com/embed/AHHVd0abOck<?php echo $value['video'] ?>?ecver=2" width="100%" height="357" frameborder="0" allowfullscreen></iframe>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <?php if(count($slide_left) > 2){ ?>
      <!-- Controls -->
      <a class="left carousel-control" href="#catalog-slider" role="button" data-slide="prev">
        <span class="control-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#catalog-slider" role="button" data-slide="next">
        <span class="control-chevron-right"></span>
      </a>
      <?php } ?>
    </div>
    </div>
    <div class="col-md-6 col_sm">
      <div id="catalog-slider-2" class="carousel carousel-fade slide slide-home" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php if(count($slide_right) > 2){ foreach ($slide_right as $key => $value) { ?>
          <li data-target="#catalog-slider-2" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>"></li>
        <?php } } ?>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner full-view" role="listbox">
        <?php foreach ($slide_right as $key => $value) { ?>
          <div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
            <?php if($value['type'] == '1'){ ?>
            <a href="<?php echo (!empty($value['link'])) ? $value['link'] : '#'; ?>">
              <img src="<?php echo base_url('assets/image/slideshow/'.$value['image']) ?>" class="img-responsive" alt="<?php echo $value['name'] ?>">
            </a>
            <?php } else { ?>
              <iframe class="ivideo" src="https://www.youtube.com/embed/<?php echo $value['video'] ?>?ecver=2" width="100%" height="357" frameborder="0" allowfullscreen></iframe>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <?php if(count($slide_right) > 2){ ?>
      <!-- Controls -->
      <a class="left carousel-control" href="#catalog-slider-2" role="button" data-slide="prev">
        <span class="control-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#catalog-slider-2" role="button" data-slide="next">
        <span class="control-chevron-right"></span>
      </a>
      <?php } ?>
    </div>
    </div>
  </div>
</div>

<div class="main-home">
<div class="container">



<?php if(count($item_featured) > 0) : ?>
<div id="products-home">
<h2 class="title-border-dashed">PRODUK UNGGULAN</h2>
  <div class="row row-mar">
  <div class="col-sm-12 col-pad  main-by-category">
  <div class="item_carousel owl-carousel owl-theme">
    <?php foreach ($item_featured as $key => $value) { 
      $color = (!empty($value['ColorName'])) ? ' - '.ucwords(strtolower($value['ColorName'])) : '';
      $uricolor = (!empty($value['ColorName'])) ? '/'.my_slug($value['ColorName']) : '';
    ?>
      <div class="item">
        <div class="box-item">
        <a href="<?php echo base_url('shop/products/'.$value['url'].$uricolor) ?>">
        <div class="box-image-show">
          <img src="<?php echo base_url('assets/image/product/'.$value['image1']) ?>" alt="<?php echo $value['ItemName'] ?>">
          <div class="inner-center">
            <div class="hover-cart"></div>
          </div>
        </div>
        </a>
        <a title="<?php echo $value['ItemName'] . $color ?>" href="<?php echo base_url('shop/products/'.$value['url'].$uricolor) ?>">
        <div class="box-item-info">
          <div class="product_name"><span><b><?php echo $value['ItemName'] . $color ?></b></span></div>
          <div class="product_shortdesc"><?php echo $value['ItemNmDesc'] ?></div>

          <div class="product_price">
            <?php if($value['ItemDisc'] > 0){ ?>
            <span class="disc-notif">
            <?php if($value['ItemDisc'] <= 100){ echo $value['ItemDisc'].'%'; 
            } else{ echo '- '.rupiah($value['ItemDisc']); } ?>
            </span>
            <span style="text-decoration: line-through">&nbsp;IDR <?php echo rupiah($value['ItemPrice']) ?>&nbsp;</span><br>
            <span style="color: #F44336;">
            <?php 
            if($value['ItemDisc'] <= 100){ 
              echo 'IDR '.rupiah($value['ItemPrice'] - ($value['ItemPrice']*$value['ItemDisc'])/100);
            } else {
              echo 'IDR '.rupiah($value['ItemPrice'] - $value['ItemDisc']);
            }
            ?>
            </span>
            <?php } else { ?>
            IDR <?php echo rupiah($value['ItemPrice']) ?>
            <?php } ?>
            </div>
        </div>
        </a>
        </div>
      </div>
    <?php } ?>
  </div>
  </div>
  </div>
</div>
<?php endif; ?>



<div id="new_products" class="spacer bot pt-0">
<h2 class="title-border-dashed">PRODUK TERBARU</h2>
  <div class="row row-mar">
  <div class="col-sm-12 col-pad  main-by-category">
  <div class="item_carousel_2 owl-carousel owl-theme hidden-xs">
    <?php foreach ($item as $key => $value) { 
      $color    = (!empty($value['ColorName'])) ? ' - '.ucwords(strtolower($value['ColorName'])) : '';
      $uricolor = (!empty($value['ColorName'])) ? '/'.my_slug($value['ColorName']) : '';
    ?>
      <div class="item">
        <div class="box-item">
        <a href="<?php echo base_url('shop/products/'.$value['url'].$uricolor) ?>">
        <div class="box-image-show">
          <img src="<?php echo base_url('assets/image/product/'.$value['image1']) ?>" alt="<?php echo $value['ItemName'] ?>">
          <div class="inner-center">
            <div class="hover-cart"></div>
          </div>
        </div>
        </a>
        <a title="<?php echo $value['ItemName'] . $color ?>" href="<?php echo base_url('shop/products/'.$value['url'].$uricolor) ?>">
        <div class="box-item-info">
          <div class="product_name"><span><b><?php echo $value['ItemName'] . $color ?></b></span></div>
          <div class="product_shortdesc"><?php echo $value['ItemNmDesc'] ?></div>

          <div class="product_price">
            <?php if($value['ItemDisc'] > 0){ ?>
            <span class="disc-notif">
            <?php if($value['ItemDisc'] <= 100){ echo $value['ItemDisc'].'%'; 
            } else{ echo '- '.rupiah($value['ItemDisc']); } ?>
            </span>
            <span style="text-decoration: line-through">&nbsp;IDR <?php echo rupiah($value['ItemPrice']) ?>&nbsp;</span><br>
            <span style="color: #F44336;">
            <?php 
            if($value['ItemDisc'] <= 100){ 
              echo 'IDR '.rupiah($value['ItemPrice'] - ($value['ItemPrice']*$value['ItemDisc'])/100);
            } else {
              echo 'IDR '.rupiah($value['ItemPrice'] - $value['ItemDisc']);
            }
            ?>
            </span>
            <?php } else { ?>
            IDR <?php echo rupiah($value['ItemPrice']) ?>
            <?php } ?>
            </div>
        </div>
        </a>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="row row-mar visible-xs">
    <?php foreach ($item as $key => $value) { 
      $color    = (!empty($value['ColorName'])) ? ' - '.ucwords(strtolower($value['ColorName'])) : '';
      $uricolor = (!empty($value['ColorName'])) ? '/'.my_slug($value['ColorName']) : '';
    ?>
    <div class="col-xs-6 col-sm-4 col-pad">
    <div class="box-item">
    <a href="<?php echo base_url('shop/products/'.$value['url'].$uricolor) ?>">
    <div class="box-image-show">
      <img src="<?php echo base_url('assets/image/product/'.$value['image1']) ?>" alt="<?php echo $value['ItemName'] ?>">
      <div class="inner-center">
        <div class="hover-cart"></div>
      </div>
    </div>
    </a>
    <div class="box-item-info">
      <div class="product_name">
        <a href="<?php echo base_url('shop/products/'.$value['url'].$uricolor) ?>">
      <span><b><?php echo $value['ItemName'] ?></b></a></div>
      <div class="product_shortdesc"><?php echo $value['ItemNmDesc'] ?></div>
      <div class="product_price">
      <?php if($value['ItemDisc'] > 0){ ?>
      <span class="disc-notif">
      <?php if($value['ItemDisc'] <= 100){ echo $value['ItemDisc'].'% off'; 
      } else{ echo '- '.rupiah($value['ItemDisc']); } ?>
      </span>
      <span style="text-decoration: line-through">&nbsp;IDR <?php echo rupiah($value['price']) ?>&nbsp;</span><br>
      <span style="color: #F44336;">
      <?php 
      if($value['ItemDisc'] <= 100){ 
        echo 'IDR '.rupiah($value['price'] - ($value['price']*$value['ItemDisc'])/100);
      } else {
        echo 'IDR '.rupiah($value['price'] - $value['ItemDisc']);
      }
      ?>
      </span>
      <?php } else { ?>
      IDR <?php echo rupiah($value['price']) ?>
      <?php } ?>
      </div>
    </div>
    </div>
    </div>
    <?php } ?>
  </div>


  </div>
  </div>
 
  <div class="text-center">
  <a href="<?php echo base_url('shop/catalogue') ?>" class="btn btn-sm btn-main-red"><span>SHOP NOW</span></a>
  </div>

</div>

<hr>
<div class="shop-short-about">

<div class="row">
  <div class="col-md-offset-1 col-md-10 text-center x2">
  
  <?php echo $home_desc['deskripsi'] ?>
  <!-- <p>
    Mulai perjalanan glowing-mu dengan Tan Skin sekarang dan tunjukkan <a style="color: #be0010;" href="https://www.instagram.com/explore/tags/beautifulskintoday/" target="_blank">#BeautifulSkinToday</a> dan <a style="color: #be0010;" href="https://www.instagram.com/explore/tags/confidenteveryday/" target="_blank">#ConfidentEveryday-mu</a>
  </p> -->
  
  </div>
  
</div>

</div>
<hr>


</div>

<?php if(!empty($feed['data'])){ ?>
<div class="container">
  <h2 class="title-border-dashed">INSTAGRAM</h2>
</div>
<div id="instafeed" class="owl-carousel">
  <?php  foreach ($feed['data'] as $key => $value) { 
    if($value['media_type'] != 'VIDEO') { 
       ?>
  <div class="item"><a href="<?php echo $value['permalink'] ?>" target="_blank"> <img src="<?php echo $value['media_url'] ?>" alt=""> </a> </div>
  <?php  } }  ?>
</div>
<?php } ?>

<script type="text/javascript">
$(function(){
  <?php if(!empty($feed['data'])){ ?>
  $('#instafeed').owlCarousel({
      loop: true,
      nav: true,
      dots: false,
      autoplay:true,
      navText:["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"],
      responsive:{
        0:{
          items:3
        },
        768:{
          items:4
        },
        992:{
          items:6
        }
      }
  });
  <?php } ?>

  $('.item_carousel').owlCarousel({
      loop:true,
      margin:15,
      nav:true,
      dots: false,
      navText:["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"],
      responsive:{
          0:{
              items:2
          },
          768:{
              items:4
          },
          992:{
              items:5
          }
      }
  });
  $('.item_carousel .owl-nav, .item_carousel .owl-dots').removeClass('disabled');

  $('.item_carousel_2').owlCarousel({
      loop:true,
      margin:15,
      nav:true,
      dots: false,
      navText:["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"],
      responsive:{
          0:{
              items:2
          },
          768:{
              items:3
          },
          992:{
              items:5
          }
      }
  });
  $('.item_carousel_2 .owl-nav, .item_carousel_2 .owl-dots').removeClass('disabled');

  $('.offer_carousel').owlCarousel({
    loop:true,
    nav:true,
    dots: true,
    items:1,
    navText:["<i class='fa fa-angle-left fa-2x'></i>", "<i class='fa fa-angle-right fa-2x'></i>"],
  });

});
</script>