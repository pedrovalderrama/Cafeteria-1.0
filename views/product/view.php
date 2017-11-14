<!-- Page Content -->
<div class="container">
   <div class="row" style="margin-top:100px;">
      <form action="products" method="post" class="form-inline float-right hidden-xs hidden-sm" style="margin-bottom:-50px;">
         <label for="Supplier"><?=label("Supplier");?></label>
         <select class="form-control" id="Supplier" name="filtersupp">
            <option value=''><?=label("All");?></option>
            <?php foreach ($suppliers as $supplier):?>
               <option value="<?=$supplier->name;?>" <?=$supplierF === $supplier->name ? 'selected' : ''; ?>><?=$supplier->name;?></option>
            <?php endforeach;?>
         </select>
         <label for="Producttype"><?=label("ProductType");?></label>
         <select class="form-control" id="Producttype" name="filtertype">
            <option value=''><?=label("All");?></option>
            <option value="0" <?=$typeF === '0' ? 'selected' : ''; ?>><?=label("Standard");?></option>
            <option value="1" <?=$typeF === '1' ? 'selected' : ''; ?>><?=label("Service");?></option>
            <option value="2" <?=$typeF === '2' ? 'selected' : ''; ?>><?=label("combination");?></option>
         </select>
         <button type="submit" class="btn btn-default"><?=label("ApplyFilter");?></button>
      </form>
      <table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="hidden-xs"><?=label("ProductCode");?></th>
                  <th><?=label("ProductName");?></th>
                  <th><?=label("Category");?></th>
                  <th class="hidden-xs"><?=label("ProductDescription");?></th>
                  <th class="hidden-xs"><?=label("ProductTax");?></th>
                  <th><?=label("Price");?></th>
                  <th><?=label("Action");?></th>
              </tr>
          </thead>

          <tbody>
             <?php foreach ($products as $product):?>
              <tr>
                 <td class="hidden-xs productcode"><?=$product->code;?></td>
                 <td><?=$product->name;?></td>
                 <td><?=$product->category;?></td>
                 <td class="hidden-xs"><?=character_limiter($product->description, 40);?></td>
                 <td><?=$product->tax;?></td>
                 <td  data-order="<?=$product->price;?>"><?=number_format((float)$product->price, $this->setting->decimals, '.', '');?> <?=$this->setting->currency;?></td>
                 <td><div class="btn-group">
                       <?php if($this->user->role === "admin"){?><a class="btn btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="left"  data-html="true" title='<?=label("Areyousure");?>' data-content='<a class="btn btn-danger" href="products/delete/<?=$product->id;?>"><?=label("yesiam");?></a>'><i class="fa fa-times"></i></a><?php } ?>
                       <a class="btn btn-default" href="javascript:void(0)" onclick="Viewproduct(<?=$product->id;?>)"><i class="fa fa-file-text" data-toggle="tooltip" data-placement="top" title="<?=label('Viewproduct');?>"></i></a>
                       <a class="btn btn-default" href="products/edit/<?=$product->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Edit');?>"><i class="fa fa-pencil"></i></a>
                       <?php if($this->user->role === "admin" && $product->type === 0 ){?><a class="btn btn-default" href="javascript:void(0)" onclick="modifystock(<?=$product->id;?>)"><i class="fa fa-tasks" data-toggle="tooltip" data-placement="top"  title='<?=label("ModifyStock");?>'></i></a><?php } ?>
                       <?php if($product->photo){ ?><a class="btn <?=$product->color;?> white open-modalimage"data-id="<?=$product->photo;?>" href="" data-toggle="modal" data-target="#ImageModal"><i class="fa fa-picture-o" data-toggle="tooltip" data-placement="top" title="<?=label('ViewImage');?>"></i></a><?php } ?>
                       <a class="btn btn-default" href="javascript:void(0)" data-toggle="modal" data-target="#barcode" onclick="productBcode = <?=$product->code;?>"><i class="fa fa-barcode" data-toggle="tooltip" data-placement="top" title="<?=label('printBarcodes');?>"></i></a>
                     </div>
                  </td>
              </tr>
           <?php endforeach;?>
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#Addproduct"><?=label("AddProduct");?></button>

   <div class=" float-right">
      <a class="btn btn-add btn-xs" href="products/csv"><?=label("DownloadCSV");?></a>
      <a class="btn btn-add btn-xs" data-toggle="modal" data-target="#ImportProducts"><?=label("UploadCSVfile");?></a>
   </div>
</div>
<!-- /.container -->

<div class="modal fade" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel"><?=label("ProductImage");?></h4>
         </div>
         <div class="modal-body">
           <img id="image" src="" class="img-responsive center" alt="" />
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
         </div>
      </div>
   </div>
</div>

<script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
<script type="text/javascript">
var items = [];
$(function() {
   $('#addform').submit(function()
   {
      var error = false;
      $('.productcode').each(function() {
         if($(this).text() === $("#ProductCode").val()){
            $('#codeError').show();
            error = true;
         }
      });
      if(error) return false;
       // ... continue work
   });

   $('#Type').on('change', function() {
     if( this.value == 1 ) //if service
     {
        $("#pushaceP").slideUp();
        $("#alertqty").slideUp();
        $("#supply").slideUp();
        $("#UnitP").slideUp();
     } else if ( this.value == 2 ) {
        $("#pushaceP").slideUp();
        $("#alertqty").slideUp();
        $("#supply").slideUp();
        $("#UnitP").slideUp();
     } else {
        $("#pushaceP").slideDown();
        $("#alertqty").slideDown();
        $("#supply").slideDown();
        $("#UnitP").slideDown();
     }
   });
});


$(document).on("click", ".open-modalimage", function () {
  var myId = $(this).data('id');
  $(".modal-body #image").attr("src","<?php echo site_url()?>/files/products/"+myId);
});


var quant = [];
var quantw = [];
var pricestore = [];
var productID;
$(document).ready(function() {

   $('#addform').ajaxForm({ //FormID - id of the form.

         success: function (data) {
            if(data === "service")
            {
               location.reload();
            }else if($('#Type').value == 1) {
               $('#stockcontent').html(data);
               $('#stock').modal('show');
               $('#Addproduct').modal('hide');

               $( "[id='quantity']" ).on('change', function() {
                  var storeID = $(this).attr("store-id");
                  quant.push({
                     'store_id': storeID,
                     'quantity': $(this).val()
                  });
               });

               $( "[id='quantityw']" ).on('change', function() {
                  var warehouseID = $(this).attr("warehouse-id");
                  quantw.push({
                     'warehouse_id': warehouseID,
                     'quantity': $(this).val()
                  });
               });

               $( "[id='pricestr']" ).on('change', function() {
                  var storeID = $(this).attr("store-id");
                  pricestore.push({
                     'store_id': storeID,
                     'price': $(this).val()
                  });
               });

               productID = $('#prodctID').val();
            } else {

               productID = $('#prodctID').val();
               $('#combocontent').html(data);
               $('#combo').modal('show');
               $('#Addproduct').modal('hide');

               $("#add_item").autocomplete({
                  source: '<?= site_url('productcontroller/suggest'); ?>',
                  minLength: 1,
                  autoFocus: false,
                  delay: 200,
                  select: function( event, ui ) {

                           event.preventDefault();
                           if (ui.item.id !== 0) {
                              var row = add_product_item(ui.item);
                              if (row) {
                                 $(this).val('');
                              }
                           } else {
                              alert('<?= label('NoProduct') ?>');
                              return false;
                           }
                        },
                  response: function (event, ui) {
                       if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                           alert('<?= label('NoProduct') ?>');
                           $('#add_item').focus();
                           $(this).val('');
                       }
                       else if (ui.content.length == 1 && ui.content[0].id != 0) {
                           ui.item = ui.content[0];
                           $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                           $(this).autocomplete('close');
                           $(this).removeClass('ui-autocomplete-loading');
                       }
                       else if (ui.content.length == 1 && ui.content[0].id == 0) {
                           alert('<?= label('NoProduct') ?>');
                           $('#add_item').focus();
                           $(this).val('');

                       }
                  }
               });

            }
      }
   });
});

function add_product_item(item, noitem) {
   if (item == null && noitem == null) {
      return false;
   }
   if(noitem != 1) {
      var item_id = 0;
      $.each(items, function(i){
         if(items[i].item_id == item.id) {
            items[i].quantity = (parseFloat(items[i].quantity) + 1);
            item_id = item.id;
            return false;
         }
      });
      if(item_id == 0) {
         item.qty = 1;
         items.push({
            'item_id': item.id,
            'quantity': item.qty,
            'code': item.code,
            'name': item.name
         });
      }
   }


   $("#Comboprd tbody").empty();
   items.forEach(function(item) {
      var Tr = $('<tr id="rowid_' + item.item_id + '" class="item_' + item.item_id + '"></tr>');
      td = '<td>' + item.name + ' (' + item.code + ')</td>';
      td += '<td><input class="form-control text-center" name="quantity" type="text" value="' + item.quantity + '" item-id="' + item.item_id + '" id="quantit"></td>';
      td += '<td class="text-center"><i class="fa fa-times tip delt" id="' + item.item_id + '" title="Remove" style="cursor:pointer;"></i></td>';
      Tr.html(td);
      Tr.prependTo("#Comboprd");
   });
   console.log(items);
   $( "[id='quantit']" ).on('change', function() {
      var itemID = $(this).attr("item-id");
      var val = $(this).val();
      items.forEach(function(e) {
         if(e.item_id == itemID) {
            e.quantity = val;
         }
      });
      console.log(items);
   });
   return true;

}

function addcombo(){
   var productID = $('#prodctID').val();
   $.ajax({
          url : "<?php echo site_url('productcontroller/addcombo')?>/",
          type: "POST",
          data: {items: items, productID: productID},
          success: function(data)
          {
             location.reload();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
}

function updatestock(){
      $.ajax({
          url : "<?php echo site_url('products/updatestock')?>/",
          data: {quant: quant, quantw: quantw, productID: productID, pricest: pricestore},
          type: "POST",
          success: function(data)
          {
            location.reload();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
             alert("error");
          }
     });
    };
function modifystock(id){
   $.ajax({
       url : "<?php echo site_url('productcontroller/modifystock')?>/"+id,
       type: "POST",
       success: function(data)
       {
          $('#stockcontent').html(data);
          $('#stock').modal('show');

          $( "[id='quantity']" ).on('change', function() {
            var storeID = $(this).attr("store-id");
            quant.push({
               'store_id': storeID,
               'quantity': $(this).val()
           });
           });

           $( "[id='quantityw']" ).on('change', function() {
            var warehouseID = $(this).attr("warehouse-id");
            quantw.push({
               'warehouse_id': warehouseID,
               'quantity': $(this).val()
           });
           });

           $( "[id='pricestr']" ).on('change', function() {
            var storeID = $(this).attr("store-id");
            pricestore.push({
               'store_id': storeID,
               'price': $(this).val()
           });
           });

           productID = $('#prodctID').val();
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
  });
}


function Viewproduct(id){
   $.ajax({
       url : "<?php echo site_url('productcontroller/Viewproduct')?>/"+id,
       type: "POST",
       success: function(data)
       {
          $('#viewSectionProduct').html(data);
          $('#Viewproduct').modal('show');
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
  });
}

$(document).on('click', '.delt', function () {
    var id = $(this).attr('id');
    $.each(items, function(i){
       if(items[i].item_id == id) {
           items.splice(i,1);
           return false;
       }
   });
    $(this).closest('#rowid_' + id).remove();
    console.log(items);
});

function modifycombo(id){
   $.ajax({
       url : "<?php echo site_url('productcontroller/modifycombo')?>/"+id,
       type: "POST",
       success: function(data)
       {
          $('#combocontent').html(data);
          $('#Viewproduct').modal('hide');
          $('#combo').modal('show');
          $.ajax({
              url : "<?php echo site_url('productcontroller/getcombos')?>/"+id,
              type: "POST",
              success: function(data){
                 dataitems = JSON.parse(data);
                 dataitems.forEach(function(e) {
                    items.push({
                       'item_id': e.item_id,
                       'quantity': e.quantity,
                       'code': e.code,
                       'name': e.name
                    });
                  });
            },
              error: function (jqXHR, textStatus, errorThrown){alert("error");}
         });
          console.log(items);
          $("#add_item").autocomplete({
             source: '<?= site_url('productcontroller/suggest'); ?>',
             minLength: 1,
             autoFocus: false,
             delay: 200,
             select: function( event, ui ) {

                      event.preventDefault();
                      if (ui.item.id !== 0) {
                         var row = add_product_item(ui.item);
                         if (row) {
                            $(this).val('');
                         }
                      } else {
                         alert('<?= label('NoProduct') ?>');
                         return false;
                      }
                   },
             response: function (event, ui) {
                  if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                      alert('<?= label('NoProduct') ?>');
                      $('#add_item').focus();
                      $(this).val('');
                  }
                  else if (ui.content.length == 1 && ui.content[0].id != 0) {
                      ui.item = ui.content[0];
                      $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                      $(this).autocomplete('close');
                      $(this).removeClass('ui-autocomplete-loading');
                  }
                  else if (ui.content.length == 1 && ui.content[0].id == 0) {
                      alert('<?= label('NoProduct') ?>');
                      $('#add_item').focus();
                      $(this).val('');

                  }
             }
          });
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
  });
}


function barcode(){
   row = $('#Brrows').val();
   num = $('#Brnum').val();
   $.ajax({
       url : "<?php echo site_url('productcontroller/barcode')?>/"+row+"/"+num+"/"+productBcode,
       type: "POST",
       success: function(data)
       {
          $('#printSection').html(data);
          $('#barcodeP').modal('show');
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
  });
}

function Printbarcode() {
   $('.modal-body').removeAttr('id');
   window.print();
   $('.modal-body').attr('id', 'modal-body');
}

function makePrdInvis(id, prd) {
   $.ajax({
       url : "<?php echo site_url('productcontroller/makePrdInvis')?>/"+id+"/"+prd,
       type: "POST",
       success: function(data){},
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
  });
}



</script>

<!-- Modal -->
<div class="modal fade" id="Addproduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddProduct");?></h4>
      </div>
      <?php
      $attributes = array('id' => 'addform');
      echo form_open_multipart('productcontroller/add', $attributes);
      ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="Type"><?=label("Type");?></label>
             <select class="form-control" name="type" id="Type">
               <option value="0"><?=label("Standard");?></option>
               <option value="1"><?=label("Service");?></option>
               <option value="2"><?=label("combination");?></option>
             </select>
            </div>
            <div class="form-group controls">
             <label for="ProductCode"><?=label("ProductCode");?></label>
             <input type="text" maxlength="30" Required name="code" class="form-control" id="ProductCode" placeholder="<?=label("ProductCode");?>">
             <p id="codeError" class="red" hidden><?=label("codeerror");?></p>
           </div>
           <div class="form-group">
             <label for="ProductName"><?=label("ProductName");?></label>
             <input type="text" name="name" maxlength="25" Required class="form-control" id="ProductName" placeholder="<?=label("ProductName");?>">
           </div>
           <div class="form-group">
             <label for="Category"><?=label("Category");?></label>
             <select class="form-control" name="category" id="Category">
               <option><?=label("Category");?></option>
               <?php foreach ($categories as $category):?>
                  <option value="<?=$category->name;?>"><?=$category->name;?></option>
               <?php endforeach;?>
            </select>
           </div>
           <div class="form-group" id="supply">
             <label for="Supplier"><?=label("Supplier");?></label>
             <select class="form-control" name="supplier" id="Supplier">
               <option><?=label("Supplier");?></option>
               <?php foreach ($suppliers as $supplier):?>
                  <option value="<?=$supplier->name;?>"><?=$supplier->name;?></option>
               <?php endforeach;?>
            </select>
           </div>
           <div class="form-group" id="pushaceP">
             <label for="PurchasePrice"><?=label("PurchasePrice");?> (<?=$this->setting->currency;?>)</label>
             <input type="number" step="any" value="0" Required name="cost" class="form-control" id="PurchasePrice" placeholder="<?=label("PurchasePrice");?>">
           </div>
           <div class="form-group">
             <label for="Tax"><?=label("ProductTax");?></label>
             <input type="text" maxlength="10" name="tax" class="form-control" id="Tax" placeholder="<?=label("ProductTax");?>">
           </div>
           <div class="form-group">
              <label for="taxType"><?=label("TaxMethod");?></label>
              <select class="form-control" name="taxmethod" id="taxType">
                <option value="0"><?=label("inclusive");?></option>
                <option value="1"><?=label("exclusive");?></option>
              </select>
           </div>
           <div class="form-group">
             <label for="Price"><?=label("Price");?> (<?=$this->setting->currency;?>)</label>
             <input type="number" step="any" Required name="price" class="form-control" id="Price" placeholder="<?=label("Price");?>">
           </div>
           <div class="form-group" id="UnitP">
             <label for="Unit"><?=label("Unit");?></label>
             <input type="text" step="any" name="unit" class="form-control" id="Unit" placeholder="<?=label("Unit");?>">
           </div>
           <div class="form-group" id="alertqty">
             <label for="AlertQt"><?=label("AlertQt");?></label>
             <input type="number" value="0" name="alertqt" class="form-control" id="AlertQt" placeholder="<?=label("AlertQt");?>">
           </div>
           <div class="form-group">
             <label for="exampleInputFile"><?=label("Imageinput");?></label>
             <input type="file" name="userfile" id="ImageInput">
           </div>
           <div class="form-group">
             <label for="ProductDescription"><?=label("ProductDescription");?></label>
             <textarea id="summernote" name="description"></textarea>
          </div>
           <div class="btn-group white" data-toggle="buttons">
              <p class="help-block"><?=label("ProductColor");?></p>
              <label class="btn color01">
                 <input type="radio" name="color" id="option1" value="color01" autocomplete="off" checked> C1
              </label>
              <label class="btn color02">
                 <input type="radio" name="color" id="option2" value="color02" autocomplete="off"> C2
              </label>
              <label class="btn color03">
                 <input type="radio" name="color" id="option3" value="color03" autocomplete="off"> C3
              </label>
              <label class="btn color04">
                 <input type="radio" name="color" id="option4" value="color04" autocomplete="off"> C4
              </label>
              <label class="btn color05">
                 <input type="radio" name="color" id="option5" value="color05" autocomplete="off"> C5
              </label>
              <label class="btn color06">
                 <input type="radio" name="color" id="option6" value="color06" autocomplete="off"> C6
              </label>
              <label class="btn color07">
                 <input type="radio" name="color" id="option7" value="color07" autocomplete="off"> C7
              </label>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
        <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
      </div>
   <?php echo form_close(); ?>
    </div>
 </div>
</div>
<!-- /.Modal -->

<!-- Modal -->
<div class="modal fade" id="ImportProducts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddProduct");?></h4>
      </div>
      <?php
      $attributes = array('id' => 'addform');
      echo form_open_multipart('products/importcsv', $attributes);
      ?>
      <div class="modal-body">
         <div class="form-group">
           <label for="exampleInputFile"><?=label("UploadCSVfile");?></label>
           <input type="file" name="userfile" id="ImageInput">
           <p class="help-block"><a href="<?=site_url('files/products_csv.csv');?>"><?=label('DownloadSample');?></a></p>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
        <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
      </div>
   <?php echo form_close(); ?>
    </div>
 </div>
</div>
<!-- /.Modal -->


  <!-- Modal combo -->
  <div class="modal fade" id="combo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" id="comboModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="combo"><?=label("combinations");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="combocontent">
              <!-- combo goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" onclick="location.reload();"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" onclick="addcombo()"><?=label("submit");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->

  <!-- Modal stock -->
  <div class="modal fade" id="stock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" id="stockModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="stock"><?=label("Stock");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="stockcontent">
              <!-- stock goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" onclick="location.reload();"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" onclick="updatestock()"><?=label("submit");?></button>
        </div>
      </div>
  </div>
  </div>
  <!-- /.Modal -->


  <!-- Modal view -->
  <div class="modal fade" id="Viewproduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document" id="viewModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="view"><?=label("Viewproduct");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="viewSectionProduct">
              <!-- view goes here -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->


  <!-- Modal barcode -->
  <div class="modal fade" id="barcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" id="stockModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="barcode"><?=label("Stock");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div class="form-group col-md-6">
             <label for="Price"><?=label("RowsNumber");?></label>
             <select Required class="form-control" id="Brrows">
                <option value="12">1</option>
                <option value="6">2</option>
                <option value="4">3</option>
             </select>
           </div>
           <div class="form-group col-md-6">
             <label for="Price"><?=label("Number");?></label>
             <input type="number" Required name="num" class="form-control" id="Brnum" placeholder="<?=label("Number");?>" value="10">
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" onclick="barcode()"><?=label("submit");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->


  <!-- Modal barcode -->
  <div class="modal fade" id="barcodeP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document" id="stockModal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="barcodeP"><?=label("Stock");?></h4>
        </div>
        <div class="modal-body" id="modal-body">
           <div id="printSection" style="text-align: center;">
             <!-- content -->
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
          <button type="button" class="btn btn-add hiddenpr" onclick="Printbarcode()"><?=label("print");?></button>
        </div>
      </div>
   </div>
  </div>
  <!-- /.Modal -->
