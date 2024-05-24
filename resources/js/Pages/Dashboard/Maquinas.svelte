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
        location_id: "",
        office_id: "",
        division_id: "",
        department_id: "",
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
            onBefore: () => {
                confirm(
                    `¿Está seguro de eliminar la maquina ${selectedRow.name} ${selectedRow.model}?`,
                ),
                    (selectedRow = { status: false, id: 0 });
            },
            onError: (errors) => {
                if (errors.data) {
                    displayAlert({ type: "error", message: errors.data });
                }
            },
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
                label={"Código"}
                bind:value={$formCreate.code}
                error={$formCreate.errors?.code}
            />
            <Input
                type="text"
                required={true}
                label={"Equipo"}
                bind:value={$formCreate.name}
                error={$formCreate.errors?.name}
            />
            <Input
                type="text"
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
                type="select"
                required={true}
                label={"Ubicación SSF"}
                bind:value={$formCreate.location_id}
                error={$formCreate.errors?.location_id}
            >
                {#each data.locations as option}
                    <option value={option.id}>{option.name}</option>
                {/each}
            </Input>

            <Input
                type="select"
                required={true}
                label={"Dirección/Oficina"}
                bind:value={$formCreate.office_id}
                error={$formCreate.errors?.office_id}
            >
                {#each data.offices as option}
                    <option value={option.id}>{option.name}</option>
                {/each}
            </Input>

            <Input
                type="select"
                required={true}
                label={"División"}
                bind:value={$formCreate.division_id}
                error={$formCreate.errors?.division_id}
            >
                {#each data.divisions as option}
                    {#if option.office_id == $formCreate.office_id || option.id == 1}
                        <option value={option.id}>{option.name}</option>
                    {/if}
                {/each}
            </Input>
            <Input
                type="select"
                required={true}
                label={"Departamento"}
                bind:value={$formCreate.department_id}
                error={$formCreate.errors?.department_id}
            >
                {#each data.departments as option}
                    {#if (option.division_id == $formCreate.division_id && option.division.office_id == $formCreate.office_id) || option.id == 1}
                        <option value={option.id}>{option.name}</option>
                    {/if}
                {/each}
            </Input>

            <!-- <Input
                type="file"
                label={"Foto"}
                bind:value={$formCreate.photo}
                error={$formCreate.errors?.photo}
            /> -->

            <Input
                type="textarea"
                name=""
                id=""
                label={"Observación"}
                bind:value={$formCreate.observation}
                classes={"col-span-2"}
                error={$formCreate.errors?.observation}
            />
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
        <h2 slot="header" class="text-sm text-center">EDITAR MAQUINA</h2>

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
                type="select"
                required={true}
                label={"Ubicación SSF"}
                bind:value={$formEdit.location_id}
                error={$formEdit.errors?.location_id}
            >
                {#each data.locations as option}
                    <option value={option.id}>{option.name}</option>
                {/each}
            </Input>

            <Input
                type="select"
                required={true}
                label={"Dirección/Oficina"}
                bind:value={$formEdit.office_id}
                error={$formEdit.errors?.office_id}
            >
                {#each data.offices as option}
                    <option value={option.id}>{option.name}</option>
                {/each}
            </Input>

            <Input
                type="select"
                required={true}
                label={"División"}
                bind:value={$formEdit.division_id}
                error={$formEdit.errors?.division_id}
            >
                {#each data.divisions as option}
                    {#if option.office_id == $formEdit.office_id || option.id == 1}
                        <option value={option.id}>{option.name}</option>
                    {/if}
                {/each}
            </Input>
            <Input
                type="select"
                required={true}
                label={"Departamento"}
                bind:value={$formEdit.department_id}
                error={$formEdit.errors?.department_id}
            >
                {#each data.departments as option}
                    {#if (option.division_id == $formEdit.division_id && option.division.office_id == $formEdit.office_id) || option.id == 1}
                        <option value={option.id}>{option.name}</option>
                    {/if}
                {/each}
            </Input>
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
    <h1>Maquinas</h1>

    <button
        class="btn_create"
        on:click={() => {
            showModal = true;
        }}>Nueva maquina</button
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
    <div slot="selectedButtons">
        <button
            class="bg-color4 bg-opacity-10 hover:bg-opacity-20 cursor-pointer text-2xl rounded border border-color4 px-4 py-1"
            title="Mantenimiento"
        >
            <iconify-icon icon="vaadin:tools"  class="relative -bottom-1"></iconify-icon>
        </button>
    </div>
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
            <th>Ubicación SSF</th>
            <th>Dirección/Oficina </th>
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
                            ...row,
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
                <td>
                    <img
                        class="max-w-[150px]"
                        src="http://127.0.0.1:8000/storage/{row.photo}"
                        alt=""
                    /></td
                >
                <td>{row.observation}</td>
                <td>{row.location_name}</td>
                <td>{row.office_name}</td>
            </tr>
        {/each}
    </tbody>
</Table>
