<script>
import axios from "axios";

export default {
    data() {
        return {
            offset: 0,
            limit: 5,
            isLoadingProducts: true,
            errorOcurred: false,
            productNameSearch: "",
            isSearching: false,
            products: [],
            totalProducts: 0
        };
    },
    async created() {
        this.getProducts();
        this.getProductsCount();
    },
    mounted() {
        this.$root.$on("product-created", product => {
            this.getProducts();
            this.getProductsCount();
        });
    },
    methods: {
        async getProducts() {
            this.isLoadingProducts = true;
            let resp = null;

            try {
                resp = await axios.get(
                    `/api/products?offset=${this.offset}&limit=${this.limit}`
                );
            } catch (ex) {
                console.error(ex);
                this.errorOcurred = true;
            } finally {
                this.isLoadingProducts = false;
            }

            if (this.errorOcurred) {
                return;
            }

            if (resp && resp.status === 200) {
                this.products = await resp.data;
                this.isLoadingProducts = false;
            }
        },
        async getProductsCount() {
            try {
                const resp = await axios.get("/api/products/count");
                if (resp.status === 200) {
                    this.totalProducts = resp.data.count;
                }
            } catch (ex) {
                console.error(ex);
            }
        },
        async onProductDestroy(productId) {
            try {
                const resp = await axios.delete(`/api/products/${productId}`);
                alert(`El producto ${resp.data.name} ha sido eliminado`);
                this.getProducts();
            } catch (ex) {
                console.error(ex);
            }
        },
        async onProductSearch() {
            if (this.productNameSearch === "") {
                this.getProducts();
                return;
            }

            let resp = null;
            this.isSearching = true;

            try {
                resp = await axios.get(
                    `/api/products/search?name=${this.productNameSearch}`
                );
            } catch (ex) {
                console.error(ex);
            } finally {
                this.isSearching = false;
            }

            if (resp.status === 200) {
                this.products = resp.data;
            }
        },
        async onPrevProductsPage() {
            this.offset -= this.limit;
            if (this.offset < 0) {
                this.offset = 0;
            }

            this.getProducts();
        },
        async onNextProductsPage() {
            this.offset += this.limit;
            this.getProducts();
        },
        onProductEdit(index) {
            this.$root.$emit("editing-product", this.products[index]);
        }
    }
};
</script>

<template>
    <div v-if="isLoadingProducts">
        <div class="d-flex align-items-center">
            <strong>Cargando Productos...</strong>
            <div
                class="spinner-border ml-auto"
                role="status"
                aria-hidden="true"
            ></div>
        </div>
    </div>
    <div v-else>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        Lista de Productos
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                id="product-search"
                                placeholder="Buscar producto por su nombre"
                                aria-describedby="buscar un producto por su nombre"
                                v-model="productNameSearch"
                                v-on:keyup.13="onProductSearch"
                            />
                            <div class="input-group-append">
                                <button
                                    class="btn btn-outline-primary"
                                    type="button"
                                    @click="onProductSearch"
                                >
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div
                    class="table-responsive"
                    v-if="products.length > 0 && !isSearching"
                >
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(product, index) in products"
                                :key="product.id"
                            >
                                <th scope="row">{{ product.id }}</th>
                                <td>{{ product.name }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.price | currency }}</td>
                                <td>
                                    <div
                                        class="btn-group"
                                        role="group"
                                        aria-label="Basic example"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary"
                                            data-toggle="modal"
                                            data-target="#product-edit-modal"
                                            @click="onProductEdit(index)"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            @click="
                                                onProductDestroy(product.id)
                                            "
                                        >
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 v-else-if="products.length === 0">
                    No hay productos registrados.
                </h2>
                <div v-else-if="isSearching">
                    <div class="d-flex align-items-center">
                        <strong>Buscando productos...</strong>
                        <div
                            class="spinner-border ml-auto"
                            role="status"
                            aria-hidden="true"
                        ></div>
                    </div>
                </div>
            </div>

            <div v-if="totalProducts > limit" class="card-footer">
                <button
                    v-if="offset > 0"
                    type="button"
                    class="btn btn-outline-primary float-left"
                    @click="onPrevProductsPage"
                >
                    Anterior
                </button>
                <button
                    type="button"
                    class="btn btn-outline-primary float-right"
                    v-if="
                        totalProducts - offset > 0 && products.length >= limit
                    "
                    @click="onNextProductsPage"
                >
                    Siguiente
                </button>
            </div>
        </div>
    </div>
</template>
