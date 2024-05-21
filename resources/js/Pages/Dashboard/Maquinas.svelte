<script>
    import Table from "../../components/Table.svelte";
    import Modal from "../../components/Modal.svelte";
    import Input from "../../components/Input.svelte";
    import Alert from "../../components/Alert.svelte";
    import { displayAlert } from "../../stores/alertStore";
    import { useForm } from "@inertiajs/svelte";

    let emptyDataForm = {
        code: "",
        name: "",
        brand: "",
        model: "",
        manufacturer: "",
        serial_number: "",
        photo: "",
        observation: "",
    };

    let formCreate = useForm({
        ...emptyDataForm,
    });

    let formEdit = useForm({
        ...emptyDataForm,
    });

    $: showModal = false;
    $: showModalFormEdit = false;
    $: selectedRow = { status: false, id: 0 };

    function handleSubmit(event) {
        event.preventDefault();
        $formCreate.clearErrors();
        $formCreate.post("/dashboard/maquinas", {
            onError: (errors) => {
                if (errors.data) {
                    displayAlert({ type: "error", message: errors.data });
                }
            },
            onSuccess: (mensaje) => {
                $formCreate.reset();
                displayAlert({
                    type: "success",
                    message: "Ok todo salió bien",
                });
                showModal = false;
            },
        });
    }
    function handleEdit(event) {
        event.preventDefault();
        $formEdit.clearErrors();
        $formEdit.put(`/dashboard/maquinas/${$formEdit.id}`, {
            onError: (errors) => {
                if (errors.data) {
                    displayAlert({ type: "error", message: errors.data });
                }
            },
            onSuccess: (mensaje) => {
                $formEdit.reset();
                displayAlert({
                    type: "success",
                    message: "Ok todo salió bien",
                });
                showModalFormEdit = false;
                selectedRow = { status: false, id: 0, row: {} };
            },
        });
    }
    function handleDelete(id) {
        $formCreate.delete(`/dashboard/maquinas/${id}`, {
            onBefore: () =>
                confirm(
                    `¿Está seguro de eliminar la actividad ${selectedRow.title}?`,
                ),
        });
    }
    export let data = [];

    function fillFormToEdit() {
        $formEdit.reset();
        showModalFormEdit = true;
    }
</script>

<Alert />

{#if showModal}
    <Modal bind:showModal>
        <h2 slot="header" class="text-sm text-center">CREAR ACTIVIDAD</h2>

        <form
            id="a-form"
            on:submit={handleSubmit}
            action=""
            class="w-[500px] grid grid-cols-2 gap-x-5"
        >
            <Input
                type="text"
                required={true}
                label={"Código"}
                bind:value={$formCreate.code}
                error={$formCreate.errors?.code}
            />
            <Input
                type="text"
                required={true}
                label={"Nombre"}
                bind:value={$formCreate.name}
                error={$formCreate.errors?.name}
            />
            <Input
                type="text"
                required={true}
                label={"Marca"}
                bind:value={$formCreate.brand}
                error={$formCreate.errors?.brand}
            />
            
            <Input
                type="text"
                required={true}
                label={"Modelo"}
                bind:value={$formCreate.model}
                error={$formCreate.errors?.model}
            />
            
            <Input
                type="text"
                required={true}
                label={"Fabricante"}
                bind:value={$formCreate.manufacturer}
                error={$formCreate.errors?.manufacturer}
            />
            <Input
                type="text"
                required={true}
                label={"Código de serie"}
                bind:value={$formCreate.serial_number}
                error={$formCreate.errors?.serial_number}
            />
            

            <Input
                type="file"
                label={"Foto"}
                bind:value={$formCreate.photo}
                error={$formCreate.errors?.photo}
            />
            
            <Input
                type="textarea"
                name=""
                id=""
                label={"Observación"}
                bind:value={$formCreate.observation}
                error={$formCreate.errors?.observation}
            />
        </form>
        <input
            form="a-form"
            slot="btn_footer"
            type="submit"
            value={$formCreate.processing ? "Cargando..." : "Guardar"}
            class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
        />
    </Modal>
{/if}

{#if showModalFormEdit}
    <Modal bind:showModal={showModalFormEdit}>
        <h2 slot="header" class="text-sm text-center">EDITAR ACTIVIDAD</h2>

        <form
            id="a-form"
            on:submit={handleEdit}
            action=""
            class="w-[500px] grid grid-cols-2 gap-x-5"
        >
        <Input
        type="text"
        required={true}
        label={"Código"}
        bind:value={$formCreate.code}
        error={$formCreate.errors?.code}
    />
    <Input
        type="text"
        required={true}
        label={"Nombre"}
        bind:value={$formCreate.name}
        error={$formCreate.errors?.name}
    />
    <Input
        type="text"
        required={true}
        label={"Marca"}
        bind:value={$formCreate.brand}
        error={$formCreate.errors?.brand}
    />
    <Input
        type="text"
        required={true}
        label={"Modelo"}
        bind:value={$formCreate.model}
        error={$formCreate.errors?.model}
    />

    <Input
        type="text"
        required={true}
        label={"Fabricante"}
        bind:value={$formCreate.manufacturer}
        error={$formCreate.errors?.manufacturer}
    />
    <Input
        type="text"
        required={true}
        label={"Código de serie"}
        bind:value={$formCreate.serial_number}
        error={$formCreate.errors?.serial_number}
    />


    <Input
        type="file"
        label={"Foto"}
        bind:value={$formCreate.photo}
        error={$formCreate.errors?.photo}
    />
    
    <Input
        type="textarea"
        name=""
        id=""
        label={"Observación"}
        bind:value={$formCreate.observation}
        error={$formCreate.errors?.observation}
    />
        </form>
        <input
            form="a-form"
            slot="btn_footer"
            type="submit"
            value={$formEdit.processing ? "Cargando..." : "Editar"}
            class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
        />
    </Modal>
{/if}

<div class="flex justify-between">
    <h1>Bitácora</h1>

    <button
        class="btn_create"
        on:click={() => {
            showModal = true;
        }}>Nueva actividad</button
    >
</div>

<Table
    {selectedRow}
    serverSideData={{
        ...data?.machines,
        data: "",
        filters: data.filters,
    }}
    on:fillFormToEdit={fillFormToEdit}
    on:clickDeleteIcon={() => {
        handleDelete(selectedRow.id);
    }}
>
    <thead slot="thead" class="sticky top-0 z-50">
        <tr>
            <th>Cod</th>
            <th>Maquina</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Fabricante</th>
            <th>Cód_Serie</th>
            <th>Foto</th>
            <th>Observación</th>
        </tr>
    </thead>
    <tbody slot="tbody">
        {#each data.machines?.data as row}
            <tr
                on:click={(e) => {
                    // let newSelectedRowStatus = !selectedRow.status;
                    if (row.id != selectedRow.id) {
                        selectedRow = {
                            status: true,
                            id: row.id,
                            title: row.title,
                        };
                        $formEdit.defaults({
                            ...row,
                        });
                    } else {
                        selectedRow = {
                            status: false,
                            id: 0,
                            title: "",
                        };
                        $formEdit.defaults({
                            ...emptyDataForm,
                        });
                    }
                }}
                class={`cursor-pointer hover:bg-grayBlue hover:bg-opacity-5 ${selectedRow.id == row.id ? "bg-grayBlue hover:bg-opacity-10 bg-opacity-10 brightness-110" : ""}`}
            >
                <td>{row.cod}</td>
                <td>{row.name}</td>

                <td>{row.model}</td>
                <td>{row.manufacter}</td>

                <td>{row.serial_number}</td>
                <td>{row.photo}</td>
                <td>{row.observation}</td>
            </tr>
        {/each}
    </tbody>
</Table>
