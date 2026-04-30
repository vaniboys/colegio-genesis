<button onclick="{{ $confirm ? 'voltarComConfirmacao()' : 'history.back()' }}" 
        class="btn-back">
    <i class="fas fa-arrow-left"></i> {{ $text }}
</button>

@if($confirm)
<script>
function voltarComConfirmacao() {
    if (confirm('Tem certeza que deseja sair? As alterações não salvas serão perdidas.')) {
        history.back();
    }
}
</script>
@endif