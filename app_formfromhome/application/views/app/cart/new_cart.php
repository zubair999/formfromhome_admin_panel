<style media="screen">
  .thanks{
    display: flex;
    justify-content:center;
    align-items:center;
    font-size:40px;
  }
</style>
<h1 class="thanks"><?php if($this->session->flashdata('notification')){
  echo $this->session->flashdata('notification');
} ?></h1>
