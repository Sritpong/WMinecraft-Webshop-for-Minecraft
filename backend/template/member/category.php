<div class="card-title">
  หมวดหมู่
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
  	<form id="frm_addCategory" name="frm_addCategory" method="POST">
        <div class="row">
          <div class="form-group col-12">
            <label for="category_name">ชื่อหมวดหมู่</label>
            <input type="text" class="form-control" required id="category_name" name="category_name">
          </div>
          <div class="col-12">
            <button id="btn_addServer" type="button" class="btn btn-outline-success btn-block" onclick="addCategory()">
              เพิ่มหมวดหมู่
            </button>
          </div>
        </div>
	</form>
	<hr/>
  	<table id="category_table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th style="width: 10%;">ลำดับ</th>
            <th style="width: 70%;">ชื่อหมวดหมู่</th>
            <th style="width: 20%;">#</th>
        </tr>
      </thead>
      <tbody>
        <?php
        	$sql_category = "SELECT * FROM category";
        	$query_category = query($sql_category);

          	if($query_category->rowcount() <= 0)
          	{
          	  ?>
          	    <tr>
          	      <td colspan="6" class="text-center">
          	        ยังไม่มีหมวดหมู่
          	      </td>
          	    </tr>
          	  <?php
          	}
          	else
          	{
          	  while($category = $query_category->fetch())
          	  {
          	    ?>
          	      <tr>
          	        <td>
          	          <?php echo $category['category_id']; ?>
          	        </td>
          	        <td>
          	          <?php echo $category['category_name']; ?>
          	        </td>
          	        <td>
          	        	<button class="btn btn-outline-danger" onclick="delCategory(<?php echo $category['category_id']; ?>)">
          	        		ลบ Server #<?php echo $category['category_id']; ?>
          	        	</button>
          	      </tr>
          	    <?php
          	  }
          	}
        ?>
      </tbody>
    </table>
  </div>
</div>