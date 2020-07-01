<script>
import axios from "axios";

export default {
    props: {},
    data() {
        return {
            productName: "",
            productPrice: 0,
            productDescription: "",
            productImageFile: null,
            productSubmitted: false,
            isCreatingProduct: false,
            imageWasSelected: false,
            isValidImage: false,
            errorOcurred: false
        };
    },
    methods: {
        onFileUpload() {
            this.imageWasSelected = true;
            this.productImageFile = this.$refs.productImageFile.files[0];

            if (!this.productImageFile.name.match(/.(jpg|jpeg|png|gif)$/i)) {
                this.productImageFile = null;
                this.isValidImage = false;
            } else {
                this.isValidImage = true;
            }
        },
        async onCreateProduct() {
            this.isCreatingProduct = true;
            this.errorOcurred = this.productSubmitted = false;

            const formData = new FormData();
            formData.append("name", this.productName);
            formData.append("description", this.productDescription);
            formData.append("price", this.productPrice);
            formData.append("image", this.productImageFile);

            let resp = null;
            try {
                resp = await axios.post("/api/products", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                });
            } catch (ex) {
                console.error(ex);
                this.errorOcurred = true;
            } finally {
                this.isCreatingProduct = false;
            }

            if (this.errorOcurred) {
                return;
            }

            this.productSubmitted = true;
            this.$root.$emit("product-created", resp.data);

            this.productName = this.productDescription = "";
            this.productPrice = 0;
            this.productImageFile = null;
        }
    }
};
</script>

<template>
    <div class="card">
        <div class="card-header">
            Nuevo Producto
        </div>

        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="product-name"
                        >Nombre del Producto
                        <span class="text-danger">*</span></label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="product-name"
                        aria-describedby="nombre para el producto"
                        placeholder="Escribe el nombre del producto"
                        v-model.trim="productName"
                    />
                </div>
                <div class="form-group">
                    <label for="product-price"
                        >Precio del Producto
                        <span class="text-danger">*</span></label
                    >
                    <input
                        type="number"
                        min="0"
                        id="product-price"
                        class="form-control"
                        aria-describedby="precio para el producto"
                        v-model.number="productPrice"
                        placeholder="Escribe el precio del producto en miles"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="En miles de pesos sin comas (Ej: 4400)"
                    />
                    <small id="product-price-help" class="form-text text-muted"
                        >En miles de pesos sin comas (Ej: 4400).</small
                    >
                    <small
                        v-if="productPrice < 0"
                        id="product-price-help"
                        class="form-text text-danger"
                        >El precio debe ser mayor o igual a cero.</small
                    >
                </div>
                <div class="form-group">
                    <label for="product-description"
                        >Descripción del Producto
                        <span class="text-danger">*</span></label
                    >
                    <textarea
                        class="form-control"
                        id="product-description"
                        placeholder="Escribe una descripción del producto..."
                        aria-describedby="área para describir al producto"
                        rows="3"
                        v-model.trim="productDescription"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="product-photo"
                        >Foto del Producto
                        <span class="text-danger">*</span></label
                    >
                    <div class="custom-file" id="product-photo">
                        <input
                            type="file"
                            class="custom-file-input"
                            id="customFile"
                            @change="onFileUpload"
                            ref="productImageFile"
                        />
                        <label class="custom-file-label" for="customFile">{{
                            !productImageFile
                                ? "Seleccionar Archivo"
                                : productImageFile.name
                        }}</label>
                        <small
                            v-if="!isValidImage && imageWasSelected"
                            id="product-price-help"
                            class="form-text text-danger"
                            >El archivo debe ser una imagen.</small
                        >
                    </div>
                </div>
                <div
                    v-if="errorOcurred"
                    class="alert alert-danger"
                    role="alert"
                >
                    ¡No se pudo crear el producto! Por favor, contacte con el
                    administrador del sistema.
                </div>
                <div
                    v-else-if="productSubmitted"
                    class="alert alert-success"
                    role="alert"
                >
                    ¡El producto fue creado satisfactoriamente!.
                </div>
                <button
                    type="button"
                    @click="onCreateProduct"
                    class="btn btn-block"
                    v-bind:class="{
                        'btn-secondary': isCreatingProduct,
                        'btn-primary': !isCreatingProduct
                    }"
                    v-bind:disabled="
                        productPrice < 0 ||
                            productName === '' ||
                            productDescription === '' ||
                            productImageFile === null ||
                            isCreatingProduct
                    "
                >
                    {{
                        !isCreatingProduct ? "Guardar" : "Guardando Producto..."
                    }}
                </button>
            </form>
        </div>
    </div>
</template>
