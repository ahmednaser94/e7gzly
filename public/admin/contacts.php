<?php
require_once 'header.php';
?>

<div class="site-section py-5">
    <div class="container ">
        <div class="row ">
            <div class="col-12">
                
                <h3 class="text-center font-weight-bold text-capitalize">Contacts</h3>
                <form id="about_us_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input required class="form-control input-default" name="phone" placeholder="Phone" type="text" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required class="form-control input-default" name="email" placeholder="Email" type="text" id="email">
                    </div>

                    <div class="form-group">
                        <label for="fb">Facebook</label>
                        <input required class="form-control input-default" name="fb" placeholder="Facebook" type="text" id="fb">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input required class="form-control input-default" name="twitter" placeholder="Twitter" type="text" id="twitter">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input required class="form-control input-default" name="instagram" placeholder="Instagram" type="text" id="instagram">
                    </div>
                    <div class="form-group">
                        <label for="youtube">YouTube</label>
                        <input required class="form-control input-default" name="youtube" placeholder="YouTube" type="text" id="youtube">
                    </div>
                    <div class="form-group">
                        <label for="linkedin">LinkedIn</label>
                        <input required class="form-control input-default" name="linkedin" placeholder="LinkedIn" type="text" id="linkedin">
                    </div>
                   
                    <button name="form-btn" id="contacts_button" value="update" class="btn btn-primary form-btn d-block px-5 float-left" type="submit">Update</button>

                    <button name="form-btn" value="delete" class="delete btn btn-danger form-btn d-block  px-5 float-right" type="submit">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('.delete').on("click", function(e) {
            var ok = confirm("are you sure to Delete All contacts?!");
            if (!ok) {
                e.preventDefault();
            }
        })
    </script>


    <?php require_once 'footer.php'; ?>