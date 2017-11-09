<h3 class="text-center">Please add a recipe.</h3>

<div class="row">
<div class="col-sm-offset-2 col-sm-3 ">
<H3 class="text-center"> Enter Manually </H3>
<form method="post" >
	<label for="usr">Recipe Name:</label>
  	<input type="text" class="form-control" id="RecipeName" name="RecipeName" placeholder="Recipe Name">
  	<label for="usr">Mash Temp:</label>
  	<input type="text" class="form-control" id="MashTemp" name="MashTemp" placeholder="Mash Temp">
  	<label for="usr">Mash In Volume:</label>
  	<input type="text" class="form-control" id="MashInVolume" name="MashInVolume" placeholder="Mash In Volume">
  	<label for="usr">Mash Time:</label>
  	<input type="text" class="form-control" id="MashTime" name="MashTime" placeholder="Mash Time">
  	<label for="usr">Mash Out Temp:</label>
  	<input type="text" class="form-control" id="MashOutTemp" name="MashOutTemp" placeholder="Mash Out Temp">
  	<label for="usr">Runnings:</label>
  	<input type="text" class="form-control" id="Runnings" name="Runnings" placeholder="Runnings">
	 <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
</form>

</div>



<div class="col-sm-offset-2 col-sm-3 text-center">
	<H3 class="text-center"> Import </H3>
	<p> from brewtoad or Beersmith</p>
	<form action="/inc/site/Upload.php" method="post" enctype="multipart/form-data">
    	Select file to upload:
    	<input type="file" name="fileToUpload" id="fileToUpload" accept"file_extension">
    	<input type="submit" value="Upload Config" name="submit">

	</form>
</div>
</div>

