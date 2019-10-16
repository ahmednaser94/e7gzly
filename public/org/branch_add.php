<?php
require_once 'header.php';

if (!$_SESSION['logged'])
    header('Location: ../index.php');
else if ($_SESSION['logged'] && $_SESSION['user_type'] != 4)
    header('Location: ../denied.php');
?>

<div class="container py-3">
    <div class="row ">
        <div class="col-12">
            <form id="branch-form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h3 class="text-center font-weight-bold text-capitalize">Branch Add</h3>
                <div class="form-group">
                    <input class="form-control input-default" name="br_code" placeholder="Branch Code" type="number" id="br_code" maxlength="15" required>
                    <div id="br_code_feedback" class=""></div>
                </div>
                <div class="form-group">
                    <input class="form-control input-default" name="_name" placeholder="Name" type="text" id="_name" minlength="5" maxlength="40" required>
                    <div id="name_feedback" class=""></div>
                </div>
                <div class="form-group">
                    <select required class="form-control input-default" id="area" name="area">
                        <option disabled selected value="">choose Area</option>
                    </select>
                    <div id="area_feedback" class=""></div>
                </div>
                <div class="form-group">
                    <input required class="form-control input-default" name="address" placeholder="Address" type="text" id="address" minlength="15" maxlength="100">
                    <div id="address_feedback" class=""></div>
                </div>
                <div class="form-group">
                    <input class="form-control input-default" name="br_phone" placeholder="Phone" type="number" min="0" minlength="4" maxlength="12" id="br_phone" required>
                    <div id="phone_feedback" class=""></div>
                </div>

                <button name="form-btn" value="add" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Add Branch</button>
            </form>
        </div>
    </div>

    <?php require_once 'footer.php'; ?>