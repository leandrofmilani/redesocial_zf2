<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'acl' => array(
        'roles' => array(
            'VISITANTE' => null,
            'USUARIO' => 'VISITANTE',
            'ADMIN' => 'USUARIO',
        ),
        'resources' => array(
            'Main\Index.index',
            'Main\Controller\Index.index',
            'Main\Controller\Pesquisas.index',
            'Main\Controller\Cadastros.index',
            'Main\Controller\Cadastros.novo',
            'Main\Controller\Atualizacoes.index',
            'Main\Controller\Atualizacoes.save',
            'Main\Controller\Atualizacoes.delete',
            'Admin\Controller\Comentarios.index',
            'Admin\Controller\Comentarios.save',
            'Admin\Controller\Comentarios.delete',
            'Admin\Controller\Comentarios.novo',
            'Admin\Controller\Comentarios.novocomentevento',
            'Admin\Controller\Login.index',
            'Admin\Controller\Login.login',
            'Admin\Controller\Login.logout',
            'Admin\Controller\Logout.index',
            'Admin\Controller\Usuarios.index',
            'Admin\Controller\Usuarios.save',
            'Admin\Controller\Usuarios.delete',
            'Admin\Controller\Usuarios.confirmarpresenca',
            'Admin\Controller\Usuarios.solicitaramizade',
            'Admin\Controller\Usuarios.mostraramigos',
            'Admin\Controller\Posts.index',
            'Admin\Controller\Posts.save',
            'Admin\Controller\Posts.delete',
            'Admin\Controller\Posts.curtidas',
            'Admin\Controller\Posts.get-photo',
            'Admin\Controller\Administracao.index',
            'Admin\Controller\Exibirpost.index',
            'Admin\Controller\Exibirpost.exibir',
            'Admin\Controller\Exibirpost.id',
            'Admin\Controller\Exibirevento.index',
            'Admin\Controller\Relacionamentos.index',
            'Admin\Controller\Relacionamentos.save',
            'Admin\Controller\Relacionamentos.delete',
            'Admin\Controller\Sexos.index',
            'Admin\Controller\Sexos.save',
            'Admin\Controller\Sexos.delete',
            'Admin\Controller\Perfil.save',
            'Admin\Controller\Perfil.delete',
            'Admin\Controller\Perfil.get-photo',
            'Admin\Controller\Eventos.index',
            'Admin\Controller\Eventos.save',
            'Admin\Controller\Eventos.delete',
            'Admin\Controller\Eventos.confirmarpresenca',
            'Admin\Controller\Eventos.mostrartodos',
            'Admin\Controller\Exibirperfil.index',
            'Admin\Controller\Album.index',
            'Admin\Controller\Album.save',
            'Admin\Controller\Album.get-photo',
            'Admin\Controller\Album.delete',


        ),
        'privilege' => array(
            'VISITANTE' => array(
                'allow' => array(
                    'Admin\Controller\Login.login',
                    'Admin\Controller\Login.index',
                    'Main\Controller\Index.index',
                    'Main\Controller\Cadastros.novo',
                )
            ),
            'USUARIO' => array(
                'allow' => array(
                    'Admin\Controller\Comentarios.index',
                    'Admin\Controller\Comentarios.save',
                    'Admin\Controller\Comentarios.novo',
                    'Admin\Controller\Comentarios.novocomentevento',
                    'Admin\Controller\Exibirpost.index',
                    'Admin\Controller\Exibirpost.exibir',
                    'Admin\Controller\Exibirpost.id',
                    'Admin\Controller\Exibirevento.index',
                    'Main\Controller\Pesquisas.index',
                    'Main\Index.index',
                    'Admin\Controller\Login.logout',
                    'Admin\Controller\Logout.index',
                    'Admin\Controller\Posts.index',
                    'Admin\Controller\Posts.save',
                    'Admin\Controller\Posts.curtidas',
                    'Admin\Controller\Posts.get-photo',
                    'Main\Controller\Atualizacoes.index',
                    'Main\Controller\Atualizacoes.save',
                    'Main\Controller\Atualizacoes.delete',
                    'Admin\Controller\Perfil.save',
                    'Admin\Controller\Eventos.index',
                    'Admin\Controller\Eventos.save',
                    'Admin\Controller\Eventos.delete',
                    'Admin\Controller\Eventos.mostrartodos',
                    'Admin\Controller\Exibirperfil.index',
                    'Admin\Controller\Eventos.confirmarpresenca',
                    'Admin\Controller\Usuarios.solicitaramizade',
                    'Admin\Controller\Usuarios.mostraramigos',
                    'Admin\Controller\Perfil.get-photo',
                    'Admin\Controller\Album.index',
                    'Admin\Controller\Album.save',
                    'Admin\Controller\Album.get-photo',
                    'Admin\Controller\Album.delete',
                )
            ),
            'ADMIN' => array(
                'allow' => array(
                    'Admin\Controller\Usuarios.index',
                    'Admin\Controller\Comentarios.index',
                    'Admin\Controller\Comentarios.delete',
                    'Admin\Controller\Posts.save',
                    'Admin\Controller\Usuarios.save',
                    'Admin\Controller\Usuarios.delete',
                    'Admin\Controller\Administracao.index',
                    'Admin\Controller\Posts.delete',
                    'Admin\Controller\Relacionamentos.index',
                    'Admin\Controller\Relacionamentos.save',
                    'Admin\Controller\Relacionamentos.delete',
                    'Admin\Controller\Sexos.index',
                    'Admin\Controller\Sexos.save',
                    'Admin\Controller\Sexos.delete',
                )
            ),
        )
    )
);
