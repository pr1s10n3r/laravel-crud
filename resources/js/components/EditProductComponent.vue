<script>
import axios from "axios";

export default {
    data() {
        return {
            productNameCopy: null,
            product: null,
            productImageFile: null,
            imageWasSelected: false,
            isValidImage: false,
            isUpdatingProduct: false,
            errorOcurred: false
        };
    },
    mounted() {
        this.$root.$on("editing-product", product => {
            this.product = product;
            this.productNameCopy = product.name;
        });
    },
    methods: {
        async onFileUpload() {
            this.imageWasSelected = true;
            this.productImageFile = this.$refs.productImageFile.files[0];

            if (!this.productImageFile.name.match(/.(jpg|jpeg|png|gif)$/i)) {
                this.productImageFile = null;
                this.isValidImage = false;
            } else {
                this.isValidImage = true;
            }
        },
        async onProductUpdate() {
            const formData = new FormData();
            formData.append("name", this.product.name);
            formData.append("description", this.product.description);
            formData.append("price", this.product.price);

            if (this.productImageFile) {
                formData.append("image", this.productImageFile);
            }

            this.isUpdatingProduct = true;
            this.errorOcurred = false;

            try {
                const resp = await axios.post(
                    `/api/products/${this.product.id}`,
                    formData,
                    {
                        headers: { "Content-Type": "multipart/form-data" }
                    }
                );
                this.$root.$emit("product-created", resp.data);
                this.product = resp.data;

                alert("¡El producto fue actualizado satisfactoriamente!");
            } catch (ex) {
                console.error(ex);
                this.errorOcurred = true;
                alert(
                    "El producto no pudo ser actualizado. Por favor, contacte con el administrador del sistema."
                );
            } finally {
                this.isUpdatingProduct = false;
            }
        },
        onEditClose() {
            this.isValidImage = false;
            this.imageWasSelected = false;
        }
    }
};
</script>

<template>
    <div
        class="modal fade"
        id="product-edit-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
        v-if="product"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Editando {{ productNameCopy }}
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <form>
                                <div class="form-group">
                                    <label for="product-name"
                                        >Nombre del Producto<span
                                            class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="product-name"
                                        aria-describedby="emailHelp"
                                        v-model.trim="product.name"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="product-price"
                                        >Precio del Producto<span
                                            class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="number"
                                        min="0"
                                        class="form-control"
                                        v-model.number="product.price"
                                        id="product-price"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="product-description"
                                        >Descripción del Producto
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <textarea
                                        class="form-control"
                                        id="product-description"
                                        placeholder="Escribe una descripción del producto..."
                                        aria-describedby="área para describir al producto"
                                        rows="3"
                                        v-model.trim="product.description"
                                    ></textarea>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <img
                                v-bind:src="'/images/' + product.image"
                                alt=""
                                class="product-image-editor"
                            />
                            <div class="custom-file mt-4" id="product-photo">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    id="customFile"
                                    @change="onFileUpload"
                                    ref="productImageFile"
                                />
                                <label
                                    class="custom-file-label"
                                    for="customFile"
                                    >{{
                                        !productImageFile
                                            ? "Seleccionar Archivo"
                                            : productImageFile.name
                                    }}</label
                                >
                                <small
                                    v-if="!isValidImage && imageWasSelected"
                                    id="product-price-help"
                                    class="form-text text-danger"
                                    >El archivo debe ser una imagen.</small
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="onEditClose"
                    >
                        Cerrar
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        v-bind:disabled="
                            product.price < 0 ||
                                product.name === '' ||
                                product.description === '' ||
                                isUpdatingProduct
                        "
                        @click="onProductUpdate"
                    >
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
