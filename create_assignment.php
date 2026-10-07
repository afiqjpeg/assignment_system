<?php else: ?>

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                </tr>

                            </thead>

                            <tbody>

                            <?php
                            $number = 1;

                            foreach ($categories as $category):
                            ?>

                                <tr>

                                    <td>
                                        <?= $number++ ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars(
                                                $category["category_name"]
                                            ) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $category["description"]
                                        ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>


<script>

function validateCategory() {

    const name =
        document.getElementById("category_name").value.trim();

    const description =
        document.getElementById("category_description").value.trim();


    if (name === "" || description === "") {

        alert("Please complete all fields.");

        return false;
    }


    if (name.length < 3) {

        alert(
            "Category name must contain at least 3 characters."
        );

        return false;
    }


    return true;
}

</script>

<?php require_once "footer.php"; ?>