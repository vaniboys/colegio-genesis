

<?php $__env->startSection('content'); ?>
<div class="table-card">
    <h5 class="mb-3" style="color: #1e3a8a;">
        <i class="fas fa-plus me-2"></i> Nova Avaliação - <?php echo e($turma->nome); ?>

    </h5>
    
    <form method="POST" action="<?php echo e(route('professor.avaliacao.salvar')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="turma_id" value="<?php echo e($turma->id); ?>">
        
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3"></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Enunciado (PDF, DOC, etc)</label>
            <input type="file" name="arquivo" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            <small class="text-muted">Upload do arquivo do enunciado (máx 10MB)</small>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-control" required>
                    <option value="quiz">Quiz</option>
                    <option value="prova">Prova</option>
                    <option value="trabalho">Trabalho</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Data de Entrega</label>
                <input type="date" name="data_entrega" class="form-control" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Duração (minutos)</label>
                <input type="number" name="duracao" class="form-control" placeholder="Opcional">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Pontuação Máxima</label>
                <input type="number" name="pontuacao_maxima" class="form-control" value="100" required>
            </div>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" name="publicado" class="form-check-input" id="publicado">
            <label class="form-check-label" for="publicado">Publicar imediatamente</label>
        </div>
        
        <button type="submit" class="btn-sm-custom">
            <i class="fas fa-save"></i> Salvar
        </button>
        <a href="<?php echo e(route('professor.avaliacoes', $turma->id)); ?>" class="btn-back">
            Cancelar
        </a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.professor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/professor/criar-avaliacao.blade.php ENDPATH**/ ?>