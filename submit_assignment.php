<div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>


            <?php if ($success): ?>

                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>

            <?php endif; ?>


            <?php if (!$categories): ?>

                <div class="alert alert-warning">
                    No categories are available yet.
                    Please contact the administrator.
                </div>

            <?php else: ?>


            <form
                method="POST"
                enctype="multipart/form-data"
                onsubmit="return validateProject()">


                <div class="mb-3">

                    <label class="form-label">
                        Project Title
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        maxlength="200"
                        value="<?= htmlspecialchars($_POST["title"] ?? "") ?>">

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select
                        class="form-select"
                        id="category_id"
                        name="category_id">

                        <option value="">
                            Select Category
                        </option>

                        <?php foreach ($categories as $category): ?>

                            <option
                                value="<?= $category["id"] ?>"
                                <?= (
                                    ($_POST["category_id"] ?? "") ==
                                    $category["id"]
                                ) ? "selected" : "" ?>>

                                <?= htmlspecialchars(
                                    $category["category_name"]
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        class="form-control"
                        id="description"
                        name="description"
                        rows="5"><?= htmlspecialchars($_POST["description"] ?? "") ?></textarea>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Technology Stack
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="tech_stack"
                        name="tech_stack"
                        placeholder="Example: PHP, MySQL, Bootstrap"
                        value="<?= htmlspecialchars($_POST["tech_stack"] ?? "") ?>">

                </div>


                <div class="mb-4">

                    <label class="form-label">
                        Project File
                    </label>

                    <input
                        type="file"
                        class="form-control"
                        id="project_file"
                        name="project_file"
                        accept=".pdf,.docx,.txt">

                    <small class="text-muted">
                        PDF, DOCX or TXT. Maximum 5 MB.
                    </small>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary">

                    Submit Project

                </button>

            </form>

            <?php endif; ?>

        </div>

    </div>

</div>