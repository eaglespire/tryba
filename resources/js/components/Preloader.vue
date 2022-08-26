<template>
  <div class="sbl-circ-path"></div>
</template>

<script>
export default {

}
</script>

<style>
.sbl-circ-path {
  height: 15px;
  width: 15px;
  color: rgb(255, 255, 255);
  position: relative;
  display: inline-block;
  border: 1px solid;
  border-radius: 50%;
  border-right-color: #5a5a5a;
  animation: rotate 1s linear infinite; }

@keyframes rotate {
  0% {
    transform: rotate(0); }
  100% {
    transform: rotate(360deg); } }
</style>