<!-- FloatingInput.svelte -->
<script>
    export let value = '';
    export let label = '';
    export let classes = ''
    export let type = 'text';
  </script>
 
 <div class="form__group field">

    <input bind:value {...{ type }} id="{label}" class="form__field" required  />
    <label for="{label}" class="form__label">{label}</label>
 </div>
    <!-- <input  class="bg-color1 block px-2.5 pb-2.5 pt-4 w-full text-sm   rounded-lg  appearance-none dark:text-white  focus:outline-none focus:ring-0  peer " placeholder=" "   />
    <label  class="absolute text-sm   duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] rounded-xl px-2 peer-focus:px-2 text-white peer-focus:text-color2 peer-focus:dark:text-color2  peer-placeholder-shown:text-color2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-4 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1 ">{label}</label> -->

<style>
  .form__group {
  position: relative;
  padding: 15px 0 0;
  margin-top: 10px;
  width: 100%;
}

  .form__field {
  font-family: inherit;
  width: 100%;
  border: 0;
  border-bottom: 2px solid rgb(117, 37, 37);
  outline: 0;
  font-size: 1.3rem;
  color: white;
  padding: 7px 0;
  background: transparent;
  transition: border-color 0.2s;
}

.form__field::placeholder {
  color: transparent;
}

.form__field:placeholder-shown ~ .form__label {
  font-size: 1.3rem;
  cursor: text;
  top: 20px;
}

.form__label {
  position: absolute;
  top: 0;
  display: block;
  transition: 0.2s;
  font-size: 1rem;
  color: gray;
}

.form__field:focus ~ .form__label {
  position: absolute;
  top: 0;
  display: block;
  transition: 0.2s;
  font-size: 1rem;
  color: #11998e;
  font-weight: 700;
}

.form__field:focus {
  padding-bottom: 6px;
  font-weight: 700;
  border-width: 3px;
  border-image: linear-gradient(to right, #11998e, #38ef7d);
  border-image-slice: 1;
}

/* Reset input */
.form__field:required,
.form__field:invalid {
  box-shadow: none;
}
</style>