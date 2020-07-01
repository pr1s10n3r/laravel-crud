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
            errorOcurred: false
        };
    },
    methods: {
        onFileUpload() {
            this.productImageFile = this.$refs.productImageFile.files[0];
        },
        async onCreateProduct() {
            const formData = new FormData();
            formData.append("name", this.productName);
            formData.append("description", this.productDescription);
            formData.append("price", this.productPrice);
            formData.append("image", this.productImageFile);

            // TODO: Validate if image file is an image
            let resp = null;
            try {
                resp = await axios.post("/api/products", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                });
            } catch (ex) {
                console.error(ex);
                this.errorOcurred = true;
            }

            console.log("status code: " + resp.status);
            console.log(await resp.text());
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
                        v-model="productName"
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
                        v-model="productPrice"
                    />
                    <small
                        v-if="productPrice < 0"
                        id="product-price-help"
                        class="form-text text-muted"
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
                        v-model="productDescription"
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
                                ? "Choose file"
                                : productImageFile.name
                        }}</label>
                    </div>
                </div>
                <button
                    type="button"
                    @click="onCreateProduct"
                    class="btn btn-primary btn-block"
                    v-bind:disabled="
                        productPrice < 0 ||
                            productName === '' ||
                            productDescription === '' ||
                            isCreatingProduct
                    "
                >
                    Guardar
                </button>
            </form>
        </div>
    </div>
</template>
