<?php
/**
 * The template for displaying user list.
 *
 * @package ManageUsers
 * @since 1.0.0
 */

// Initialise the plugin main class.
$user_page = new Milan\ManageUsers\Page\UserPage();

get_header();
?>

	<div class="wp-manage-users">
		<div class="container">

			<div class="header">
				<div class="row">
					<div class="col">
						<h3 class="py-3"><?php echo esc_html( $user_page->get_page_title() ); ?></h3>
					</div>
				</div>
			</div>

			<div class="user-list-table">
				<div class="row">
					<div class="col">
						<table class="table table-hover loading">
							<thead>
							<tr>
								<th scope="col"><?php _e( 'ID', 'wp-manage-users' ); ?></th>
								<th scope="col"><?php _e( 'Name', 'wp-manage-users' ); ?></th>
								<th scope="col"><?php _e( 'Username', 'wp-manage-users' ); ?></th>
								<th scope="col"><?php _e( 'Email', 'wp-manage-users' ); ?></th>
							</tr>
							</thead>
							<tbody>
							<tr class="loader">
								<td class="td-1"><span></span></td>
								<td class="td-2"><span></span></td>
								<td class="td-3"><span></span></td>
								<td class="td-4"><span></span></td>
							</tr>
							<tr class="loader">
								<td class="td-1"><span></span></td>
								<td class="td-2"><span></span></td>
								<td class="td-3"><span></span></td>
								<td class="td-4"><span></span></td>
							</tr>
							<?php $user_page->render_user_list(); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="user-details">
				<!-- Modal -->
				<div class="modal fade" id="userDetailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title fs-5" id="userDetailModalLabel">
									<?php echo esc_html__( 'User Information', 'wp-manage-users' ); ?>
								</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="user-details-body">
									<div class="user-detail-loading">
										<div class="loading-placeholder"><span></span></div>
										<div class="loading-placeholder"><span></span></div>
										<div class="loading-placeholder"><span></span></div>
									</div>
									<div class="user-detail-data"></div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php

get_footer();
