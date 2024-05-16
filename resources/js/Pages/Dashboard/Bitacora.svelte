<script>
    import Table from "../../components/Table.svelte";
    import Modal from "../../components/Modal.svelte";
    import Input from "../../components/Input.svelte";
    import { useForm } from "@inertiajs/svelte";

    let form = useForm({
        type_activity_id: "",
        area_id: "",
        status_id: "",
        title: "",
        user_id: "",
        start_date: "",
        end_date: "",
        location_id: "",
        office_id: "",
        division_id: "",
        department_id: "",
        progress: "",
        observation: "",
    });

    function handleSubmit(event) {
        event.preventDefault();
        $form.clearErrors()
        $form.post("/dashboard/bitacora");
    }
    let showModal = false;

    export let data = [
        {
            code: 3234,
        },
    ];

    $: console.log(data);
    $: console.log($form);
    $: console.log({ form });
</script>

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
            label={"Nombre de la actividad"}
            bind:value={$form.title}
            error={$form.errors?.title}
        />
        <Input
            type="select"
            required={true}
            label={"Tipo de actividad"}
            bind:value={$form.type_activity_id}
            error={$form.errors?.type_activity_id}
        >
            <option value="1">Asignada</option>
        </Input>

        <Input
            type="select"
            required={true}
            label={"Ubicación SSF"}
            bind:value={$form.location_id}
            error={$form.errors?.location_id}
        >
            <option value="1">ayyyy</option>
        </Input>

        <Input
            type="select"
            required={true}
            label={"Dirección/Oficina"}
            bind:value={$form.office_id}
            error={$form.errors?.office_id}
        >
            <option value="1">ayyyy</option>
        </Input>

        <Input
            type="select"
            required={true}
            label={"División"}
            bind:value={$form.division_id}
            error={$form.errors?.division_id}
        >
            <option value="1">ayyyy</option>
        </Input>
        <Input
            type="select"
            required={true}
            label={"Departamento"}
            bind:value={$form.department_id}
            error={$form.errors?.department_id}
        >
            <option value="1">ayyyy</option>
        </Input>

        <Input
            type="date"
            required={true}
            label={"Fecha de inicio"}
            bind:value={$form.start_date}
            error={$form.errors?.start_date}
        />
        <Input
            type="date"
            required={true}
            label={"Fecha de finalización"}
            bind:value={$form.end_date}
            error={$form.errors?.end_date}
        />

        <Input
            type="number"
            label={"Progreso"}
            bind:value={$form.progress}
            error={$form.errors?.progress}
        />
        <Input
            type="select"
            required={true}
            label={"Estado"}
            bind:value={$form.status_id}
            error={$form.errors?.status_id}
        >
            <option value="En desarrollo">En desarrollo</option>
            <option value="Finalizada">Finalizada</option>
            <option value="Detenida">Detenida</option>
        </Input>
        <Input
            type="textarea"
            name=""
            id=""
            label={"Observación"}
            bind:value={$form.observation}
            error={$form.errors?.observation}
            classes={'col-span-2'}
        />
    </form>
    <input
        form="a-form"
        slot="btn_footer"
        type="submit"
        value={$form.processing ? "Cargando..." : "Guardar"}
        class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
    />
</Modal>

<div class="flex justify-between">
    <h1>Bitácora</h1>

    <button class="btn_create" on:click={() => (showModal = true)}
        >Nueva actividad</button
    >
</div>
<Table>
    <thead slot="thead">
        <tr>
            <th>Cod</th>
            <th>Actividad</th>
            <th>Estado</th>
            <th>Ubicación SSF</th>
            <th>Dirección/Oficina </th>
            <th>Porcentaje</th>
            <th>Fecha</th>
            <th>Iniciada en</th>
            <th>Terminada en</th>
            <th scope="col" class="relative py-3.5 px-4">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
    </thead>

    <tbody slot="tbody">
        {#each data.data as row}
            <tr>
                <td>{row.code}</td>
                <td>{row.title}</td>
                <td>
                    <div
                        class={`inline px-3 py-1 text-sm font-normal rounded-full dark:bg-gray-800  gap-x-2  ${row.status_id == "1" ? "text-ligthGreen" : "text-gray-400"} `}
                    >
                        {row.status_name}
                    </div>
                </td>
                <td>{row.location_name}</td>9
                <td>{row.office_name}</td>
                <td>{row.progress}</td>
                <td>{row.today_date}</td>
                <td>{row.start_date}</td>
                <td>{row.end_date === null ? "Sin Finalizar" : row.end_date}</td
                >
                <td>
                    <button
                        class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                            />
                        </svg>
                    </button>
                </td>
            </tr>
        {/each}
    </tbody>
</Table>
