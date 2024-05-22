<script>
    import Table from "../../components/Table.svelte";
    import Modal from "../../components/Modal.svelte";
    import Input from "../../components/Input.svelte";
    import Alert from "../../components/Alert.svelte";
    import { displayAlert } from "../../stores/alertStore";
    import { useForm } from "@inertiajs/svelte";

    let emptyDataForm = {
        machine_id: "",
        type_service_id: "",
        user_id: "",
        start: "",
        description: "",
        status: "",
        duration: "",
        end: "",
        next_service_date: "",
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
        $formCreate.post("/dashboard/mantenimiento", {
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
        $formEdit.put(`/dashboard/mantenimiento/${$formEdit.id}`, {
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
        $formCreate.delete(`/dashboard/mantenimiento/${id}`, {
            onBefore: () => {
                confirm(
                    `¿Está seguro de eliminar este mantenimiento ${selectedRow.name} ${selectedRow.model}?`,
                ),
                selectedRow = { status: false, id: 0 }

            }
        });
    }
    export let data = [];
    console.log(data);
    function fillFormToEdit() {
        $formEdit.reset();
        showModalFormEdit = true;
    }
</script>

<Alert />

{#if showModal}
    <Modal bind:showModal>
        <h2 slot="header" class="text-sm text-center">CREAR MAQUINA</h2>

        <form
            id="a-form"
            on:submit={handleSubmit}
            action=""
            class="w-[500px] grid grid-cols-2 gap-x-5"
        >
        
            <Input
                type="text"
                required={true}
                label={"Maquina"}
                bind:value={$formCreate.machine_id}
                error={$formCreate.errors?.machine_id}
            />
            <Input
                type="select"
                required={true}
                label={"Tipo de mantenimiento"}
                bind:value={$formCreate.type_service_id}
                error={$formCreate.errors?.type_service_id}
            >
            </Input>
            <Input
            type="select"
            required={true}
            label={"Estado"}
            bind:value={$formCreate.status}
            error={$formCreate.errors?.status}
        >
            <!-- {#each data?.type_activities as option}
                <option value={option.id}>{option.name}</option>
            {/each} -->
        </Input>
        <Input
            type="select"
            required={true}
            label={"Responsable"}
            bind:value={$formCreate.user_id}
            error={$formCreate.errors?.user_id}
        >
            <!-- {#each data?.type_activities as option}
                <option value={option.id}>{option.name}</option>
            {/each} -->
        </Input>
            <Input
                type="date"
                label={"Fecha de inicio"}
                bind:value={$formCreate.start}
                error={$formCreate.errors?.start}
            />
            <Input
            type="textarea"
            name=""
            id=""
            label={"Descripción"}
            bind:value={$formCreate.description}
            classes={"col-span-2"}
            error={$formCreate.errors?.description}
        />
            

            <Input
            type="select"
            required={true}
            label={"Estado"}
            bind:value={$formCreate.user_id}
            error={$formCreate.errors?.user_id}
        >
            <!-- {#each data?.type_activities as option}
                <option value={option.id}>{option.name}</option>
            {/each} -->
        </Input>
       
            <Input
                type="text"
                required={true}
                label={"Duración en hr"}
                bind:value={$formCreate.duration}
                error={$formCreate.errors?.duration}
            />
            <Input
            type="date"
            label={"Fecha de entrega"}
            bind:value={$formCreate.end}
            error={$formCreate.errors?.end}
        />

            <!-- <Input
                type="file"
                label={"Foto"}
                bind:value={$formCreate.photo}
                error={$formCreate.errors?.photo}
            /> -->

            
           
            <label class="mt-3">
                Foto:

                <input
                    type="file"
                    on:input={(e) => ($formCreate.photo = e.target.files[0])}
                />
            </label>
        </form>
        <input
            form="a-form"
            slot="btn_footer"
            type="submit"
            disabled={$formCreate.processing}
            value={$formCreate.processing ? "Cargando..." : "Guardar"}
            class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
        />
    </Modal>
{/if}

{#if showModalFormEdit}
    <Modal bind:showModal={showModalFormEdit}>
        <h2 slot="header" class="text-sm text-center">EDITAR MANTENIMIENTO</h2>

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
                bind:value={$formEdit.code}
                error={$formEdit.errors?.code}
            />
            <Input
                type="text"
                required={true}
                label={"Equipo"}
                bind:value={$formEdit.name}
                error={$formEdit.errors?.name}
            />
            <Input
                type="text"
                label={"Marca"}
                bind:value={$formEdit.brand}
                error={$formEdit.errors?.brand}
            />

            <Input
                type="text"
                label={"Modelo"}
                bind:value={$formEdit.model}
                error={$formEdit.errors?.model}
            />

            <Input
                type="text"
                label={"Fabricante"}
                bind:value={$formEdit.manufacturer}
                error={$formEdit.errors?.manufacturer}
            />
            <Input
                type="text"
                required={true}
                label={"Código de serie"}
                bind:value={$formEdit.serial_number}
                error={$formEdit.errors?.serial_number}
            />

            <!-- <Input
        type="file"
        label={"Foto"}
        bind:value={$formEdit.photo}
        error={$formEdit.errors?.photo}
    /> -->

            <Input
                type="textarea"
                name=""
                id=""
                label={"Observación"}
                bind:value={$formEdit.observation}
                classes={"col-span-2"}
                error={$formEdit.errors?.observation}
            />
        </form>
        <input
            form="a-form"
            slot="btn_footer"
            type="submit"
            disabled={$formEdit.processing}
            value={$formEdit.processing ? "Cargando..." : "Editar"}
            class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
        />
    </Modal>
{/if}

<div class="flex justify-between">
    <h1>Mantenimiento</h1>

    <button
        class="btn_create"
        on:click={() => {
            showModal = true;
        }}>Nueva mantenimiento</button
    >
</div>
<!-- 
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
            <th>MANTENIMIENTO</th>
            <th>Tipo de mantenimiento</th>
            <th>Estado</th>
            <th>Responsble</th>
            <th>Fecha de inicio</th>
            <th>Descripción</th>
            <th>Duración (hr)</th>
            <th>Fecha final</th>
            <th>Prox Mantenimiento</th>
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
                            ...row
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
                            photo: "",
                        });
                    }
                }}
                class={`cursor-pointer hover:bg-grayBlue hover:bg-opacity-5 ${selectedRow.id == row.id ? "bg-grayBlue hover:bg-opacity-10 bg-opacity-10 brightness-110" : ""}`}
            >
                <td>{row.code}</td>
                <td>{row.name}</td>
                <td>{row.brand}</td>

                <td>{row.model}</td>
                <td>{row.manufacturer}</td>

                <td>{row.serial_number}</td>
                <td> <img class="max-w-[150px]" src="http://127.0.0.1:8000/storage/{row.photo}" alt="" /></td>
                <td>{row.observation}</td>
            </tr>
        {/each}
    </tbody>
</Table> -->
