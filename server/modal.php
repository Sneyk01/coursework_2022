<div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="addFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addFormModalLabel">Новая запись жителя</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">

                <div class="mb-2 text-center" style="color: red; height: 15px" id="message"></div>

                <form id="addResident">
                    <div class="mb-2">
                        <label for="resident_name" class="col-form-label">Имя:</label>
                        <input type="text" class="form-control" id="resident_name" name="resident_name">
                    </div>
                    <div class="mb-2">
                        <label for="resident_last_name" class="col-form-label">Фамилия:</label>
                        <input type="text" class="form-control" id="resident_last_name" name="resident_last_name">
                    </div>
                    <div class="mb-2">
                        <label for="resident_house" class="col-form-label">Дом:</label>
                        <input type="text" class="form-control" id="resident_house" name="resident_house">
                    </div>
                    <div class="mb-2">
                        <label for="resident_car" class="col-form-label">Номера машин (через точку с запятой):</label>
                        <input type="text" class="form-control" id="resident_car" name="resident_car">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" id="submit_button_1" form="addResident" class="btn btn-primary">Создать запись</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editFormModal" tabindex="-1" aria-labelledby="editFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editFormModalLabel">Редактировать запись жителя</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">

                <div class="mb-2 text-center" style="color: red; height: 15px" id="message_e"></div>

                <form id="editResident">
                    <div class="mb-2">
                        <label for="resident_name" class="col-form-label">Имя:</label>
                        <input type="text" class="form-control" id="resident_name_e" name="resident_name">
                    </div>
                    <div class="mb-2">
                        <label for="resident_last_name" class="col-form-label">Фамилия:</label>
                        <input type="text" class="form-control" id="resident_last_name_e" name="resident_last_name">
                    </div>
                    <div class="mb-2">
                        <label for="resident_house" class="col-form-label">Дом:</label>
                        <input type="text" class="form-control" id="resident_house_e" name="resident_house">
                    </div>
                    <div class="mb-2">
                        <label for="resident_car" class="col-form-label">Номера машин (через точку с запятой):</label>
                        <input type="text" class="form-control" id="resident_car_e" name="resident_car">
                    </div>
                    <div class="mb-2">
                        <label for="resident_telegram_id" class="col-form-label">Telegram ID:</label>
                        <input type="text" class="form-control" id="resident_telegram_id_e" name="resident_telegram_id">
                    </div>
                    <div class="mb-2">
                        <label for="resident_key" class="col-form-label">Ключ регистрации:</label>
                        <input type="text" class="form-control" id="resident_key_e" name="resident_key">
                    </div>
                    <input type="hidden" name="method" value="edit">
                    <input type="hidden" name="table_type" value="resident_table">
                    <input type="hidden" name="id" value="" id="id_e">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" id="submit_button_2" form="editResident" class="btn btn-primary">Изменить</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addFormModalVisitor" tabindex="-1" aria-labelledby="addFormModalVisitorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addFormModalVisitorLabel">Новая запись жителя</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">

                <div class="mb-2 text-center" style="color: red; height: 15px" id="visitor_message"></div>

                <form id="addVisitor">
                    <div class="mb-2">
                        <label for="visitor_car" class="col-form-label">Номер машины:</label>
                        <input type="text" class="form-control" id="visitor_car" name="visitor_car">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" id="visitor_submit_button_1" form="addVisitor" class="btn btn-primary">Создать запись</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editFormModalVisitor" tabindex="-1" aria-labelledby="editFormModalVisitorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editFormModalVisitorLabel">Редактировать запись жителя</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">

                <div class="mb-2 text-center" style="color: red; height: 15px" id="visitor_message_e"></div>

                <form id="editVisitor">
                    <div class="mb-2">
                        <label for="visitor_car" class="col-form-label">Автомобильный номер:</label>
                        <input type="text" class="form-control" id="visitor_car_e" name="visitor_car">
                    </div>
                    <div class="mb-2">
                        <label for="visitor_inv_id" class="col-form-label">ID создателя:</label>
                        <input type="text" class="form-control" id="visitor_inv_id_e" name="visitor_inv_id">
                    </div>
                    <input type="hidden" name="method" value="edit">
                    <input type="hidden" name="table_type" value="visitors_table">
                    <input type="hidden" name="id" value="" id="visitor_id_e">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" id="visitor_submit_button_2" form="editVisitor" class="btn btn-primary">Изменить</button>
            </div>
        </div>
    </div>
</div>