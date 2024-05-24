<script>
    import Table from "../../components/Table.svelte";
    import Modal from "../../components/Modal.svelte";
    import Input from "../../components/Input.svelte";
    import Alert from "../../components/Alert.svelte";
    import { displayAlert } from "../../stores/alertStore";
    import { useForm, router } from "@inertiajs/svelte";
    import clickOutside from "../../components/ClickOutside";
    let searchMachineText = "";
    $: searchMachineText, handleSearch();

    let searchedData = [];
    let selectedSearch = { row: 0, id: 0 };
    let showSearchedData = false;

    $: console.log(searchedData);

    async function handleSearch(data) {
        if (searchMachineText.length > 0) {
            console.log({ searchMachineText });
            showSearchedData = true;
            try {
                const response = await fetch(
                    `/dashboard/maquinas/search?search=${searchMachineText}`,
                    {
                        method: "GET", // or 'PUT'
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(data),
                    },
                );

                const result = await response.json();
                searchedData = result.machines;
                console.log("Success:", result);
            } catch (error) {
                console.error("Error:", error);
            }
        } else {
            showSearchedData = false;
        }
    }

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
    $: console.log($formCreate);
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

        $formCreate
            .transform((data) => ({
                ...data,
                machine_id: selectedRow.id
            }))
            .post("/dashboard/mantenimiento", {
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
                    (selectedRow = { status: false, id: 0 });
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
            class="w-[1200px] grid grid-cols-2 gap-x-5"
        >
            <div class="relative col-span-2 mx-auto">
                {#if selectedSearch.id == 0}
                    <input
                        type="search"
                        required={true}
                        label={"Maquina"}
                        placeholder="Buscar maquina"
                        class={"z-50 mx-auto p-2 mt-6 bg-dark"}
                        bind:value={searchMachineText}
                        on:focus={(e) => {
                            if (e.target.value.length > 0) {
                                showSearchedData = true;
                            }
                        }}
                    />
                {/if}

                {#if showSearchedData}
                    <!-- svelte-ignore a11y-click-events-have-key-events -->
                    <div
                        class="fixed inset-0 bg-dark bg-opacity-20 z-40 flex justify-center items-center"
                        on:click|self={() => (showSearchedData = false)}
                    >
                        <table class=" bg-dark relative -top-14 z-50">
                            <thead
                                class="[&_*]:px-4 [&_*]:py-2 [&_*]:text-left"
                            >
                                <th>Cod</th>
                                <th>Maquina</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Fabricante</th>
                                <th>Cód_Serie</th>
                                <th>Foto</th>
                                <th>Observación</th>
                                <th class="min-w-[190px]">Ubicación SSF</th>
                                <th class="min-w-[190px]"
                                    >Dirección/Oficina
                                </th>
                            </thead>
                            <tbody>
                                {#each searchedData as row}
                                    <tr
                                        on:click={(e) => {
                                            if (row.id != selectedSearch.id) {
                                                selectedSearch = { ...row };
                                            }
                                            selectedSearch = { ...row };
                                            showSearchedData = false;
                                        }}
                                        class={`[&_*]:px-4 [&_*]:py-2 cursor-pointer bg-gray-800 z-50 hover:bg-gray-700  ${selectedRow.id == row.id ? "bg-gray-800  brightness-110" : ""}`}
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
                                        <td class="min-w-[100px]"
                                            >{row.observation}</td
                                        >
                                        <td class="min-w-[100px]"
                                            >{row.location_name}</td
                                        >
                                        <td class="min-w-[100px]"
                                            >{row.office_name}</td
                                        >
                                    </tr>
                                {/each}
                                {#if searchedData.length < 1}
                                    <tr>
                                        <td
                                            colSpan={10}
                                            class="text-center p-3"
                                        >
                                            No se encontraron maquinas con su
                                            busqueda</td
                                        >
                                    </tr>
                                {/if}
                            </tbody>
                        </table>
                    </div>
                {/if}
            </div>
            {#if selectedSearch.id != 0}
                <div class="col-span-2 border rounded">
                    <table class=" bg-dark z-50 [&_*]:text-sm">
                        <thead class="[&_*]:px-4 [&_*]:py-2 [&_*]:text-left">
                            <th>Cod</th>
                            <th>Maquina</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Fabricante</th>
                            <th>Cód_Serie</th>
                            <th>Foto</th>
                            <th>Observación</th>
                            <th class="min-w-[190px]">Ubicación SSF</th>
                            <th class="min-w-[190px]">Dirección/Oficina </th>
                            <th>Quitar</th>
                        </thead>
                        <tbody>
                            {#each searchedData as row}
                                <tr
                                    class={`[&_*]:px-4 [&_*]:py-2 cursor-pointer  z-50 hover:bg-gray-700  bg-gray-900  brightness-110" : ""}`}
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
                                    <td class="min-w-[100px]"
                                        >{row.observation}</td
                                    >
                                    <td class="min-w-[100px]"
                                        >{row.location_name}</td
                                    >
                                    <td class="min-w-[100px]"
                                        >{row.office_name}</td
                                    >
                                    <td>
                                        <button
                                            class="h-full w-full cursor-pointer hover:bg-red"
                                            title="Quitar"
                                            on:click={() =>
                                                (selectedSearch = { id: 0 })}
                                        >
                                            <iconify-icon icon="mynaui:delete"
                                            ></iconify-icon>
                                        </button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
                <Input
                    type="select"
                    required={true}
                    label={"Tipo de mantenimiento"}
                    bind:value={$formCreate.type_service_id}
                    error={$formCreate.errors?.type_service_id}
                >
                    <option value="1">Preventivo</option>
                    <option value="2">Correctivo</option>
                </Input>

                <Input
                    type="select"
                    required={true}
                    label={"Responsable"}
                    bind:value={$formCreate.user_id}
                    error={$formCreate.errors?.user_id}
                >
                    {#each data?.users as option}
                        <option value={option.id}>{option.name}</option>
                    {/each}
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
                    error={$formCreate.errors?.description}
                />
                <Input
                    type="select"
                    required={true}
                    label={"Estado"}
                    bind:value={$formCreate.status}
                    error={$formCreate.errors?.status}
                >
                    <option value="1">En proceso</option>
                    <option value="2">Completado</option>
                </Input>

                {#if $formCreate.status == 2}
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
                {/if}

                <Input
                    type="date"
                    label={"Notificar prox mantenimiento el"}
                    bind:value={$formCreate.next_service_date}
                    error={$formCreate.errors?.next_service_date}
                />
            {/if}
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
                label={"Maquina"}
                bind:value={$formEdit.machine_id}
                error={$formEdit.errors?.machine_id}
            />
            <Input
                type="select"
                required={true}
                label={"Tipo de mantenimiento"}
                bind:value={$formEdit.type_service_id}
                error={$formEdit.errors?.type_service_id}
            >
                <option value="1">Preventivo</option>
                <option value="2">Correctivo</option>
            </Input>
            <Input
                type="select"
                required={true}
                label={"Estado"}
                bind:value={$formEdit.status}
                error={$formEdit.errors?.status}
            >
                <option value="1">En proceso</option>
                <option value="2">Completado</option>
            </Input>
            <Input
                type="select"
                required={true}
                label={"Responsable"}
                bind:value={$formEdit.user_id}
                error={$formEdit.errors?.user_id}
            >
                {#each data?.users as option}
                    <option value={option.id}>{option.name}</option>
                {/each}
            </Input>
            <Input
                type="date"
                label={"Fecha de inicio"}
                bind:value={$formEdit.start}
                error={$formEdit.errors?.start}
            />
            <Input
                type="textarea"
                name=""
                id=""
                label={"Descripción"}
                bind:value={$formEdit.description}
                error={$formEdit.errors?.description}
            />

            <Input
                type="text"
                label={"Duración en hr"}
                bind:value={$formEdit.duration}
                error={$formEdit.errors?.duration}
            />
            <Input
                type="date"
                label={"Fecha de entrega"}
                bind:value={$formEdit.end}
                error={$formEdit.errors?.end}
            />

            <Input
                type="date"
                label={"Notificar prox mantenimiento el"}
                bind:value={$formEdit.next_service_date}
                error={$formEdit.errors?.next_service_date}
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

<Table
    {selectedRow}
    serverSideData={{
        ...data?.services,
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
            <th>Maquina</th>
            <th>Tipo de mantenimiento</th>
            <th>Estado</th>
            <th>Responsble</th>
            <th>Fecha de inicio</th>
            <th>Descripción</th>
            <th>Duración (hr)</th>
            <th>Fecha final</th>
        </tr>
    </thead>
    <tbody slot="tbody">
        {#each data.services?.data as row}
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
                <td
                    >{row.machine_name}
                    {row.machine_brand}
                    {row.machine_model}
                    {row.machine_code}</td
                >
                <td>{row.type_service_id}</td>
                <td>{row.status}</td>

                <td>{row.user_name}</td>
                <td>{row.start}</td>
                <td>{row.description}</td>
                <td>{row.duration}</td>

                <td>{row.end}</td>
            </tr>
        {/each}
    </tbody>
</Table>
