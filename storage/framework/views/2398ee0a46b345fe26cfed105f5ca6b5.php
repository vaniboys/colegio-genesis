<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($livro->titulo); ?></title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .titulo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .autor {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        .descricao {
            margin: 20px 0;
            text-align: justify;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="titulo"><?php echo e($livro->titulo); ?></div>
        <div class="autor">Por: <?php echo e($livro->autor ?? 'Autor não informado'); ?></div>
    </div>

    <div class="info">
        <strong>Informações:</strong><br>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->editora): ?> Editora: <?php echo e($livro->editora); ?><br> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->ano_publicacao): ?> Ano: <?php echo e($livro->ano_publicacao); ?><br> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->isbn): ?> ISBN: <?php echo e($livro->isbn); ?><br> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->idioma): ?> Idioma: <?php echo e($livro->idioma); ?><br> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->descricao): ?>
    <div class="descricao">
        <strong>Descrição:</strong><br>
        <?php echo e($livro->descricao); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($livro->sinopse): ?>
    <div class="descricao">
        <strong>Sinopse:</strong><br>
        <?php echo e($livro->sinopse); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="footer">
        Documento gerado em <?php echo e(now()->format('d/m/Y H:i:s')); ?> | <?php echo e(config('app.name')); ?>

    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\colegio-genesis-oficial\resources\views/pdf/livro-exemplo.blade.php ENDPATH**/ ?>