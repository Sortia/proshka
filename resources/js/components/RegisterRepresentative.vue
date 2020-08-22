<template>
    <div class="register-representative">

        <div class="d-flex justify-content-center bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <div class="custom-control custom-checkbox align-content-center">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Есть 18 лет</label>
                </div>
            </div>
        </div>

        <div class="register-representative-fields">
            <div class="form-group row">
                <label for="surname"
                       class="col-md-4 col-form-label text-md-right">Surname</label>

                <div class="col-md-6">
                    <input id="surname" type="text"
                           class="form-control" name="surname"
                           value="{{qwe}}" required autocomplete="surname" autofocus>

                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    name: "RegisterRepresentative"
}
</script>

<style scoped>

</style>
