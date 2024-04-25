<script type="text/html" id="tmpl-wpmu-user-details">
	<#
	if ( 'undefined' !== typeof data.user.id ) {

		var user = data.user;
		#>
		<table class="table table-striped-columns">
			<tr>
				<th><?php esc_html_e( 'ID', 'wp-manage-users' ); ?></th>
				<td>{{ user.id }}</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Name', 'wp-manage-users' ); ?></th>
				<td>{{ user.name }}</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Username', 'wp-manage-users' ); ?></th>
				<td>{{ user.username }}</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Email', 'wp-manage-users' ); ?></th>
				<td>{{ user.email }}</td>
			</tr>
			<tr>
				<th rowspan="6"><?php esc_html_e( 'Address', 'wp-manage-users' ); ?></th>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'Street', 'wp-manage-users' ); ?> :</b>
					{{ user.address.street }}
				</td>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'Suite', 'wp-manage-users' ); ?> :</b>
					{{ user.address.suite }}
				</td>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'City', 'wp-manage-users' ); ?> :</b>
					{{ user.address.city }}
				</td>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'Zipcode', 'wp-manage-users' ); ?> :</b>
					{{ user.address.zipcode }}
				</td>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'GEO', 'wp-manage-users' ); ?> :</b>
					{{ user.address.geo.lat }}, {{ user.address.geo.lng }}
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Phone', 'wp-manage-users' ); ?></th>
				<td>{{ user.phone }}</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Website', 'wp-manage-users' ); ?></th>
				<td>{{ user.website }}</td>
			</tr>
			<tr>
				<th rowspan="4"><?php esc_html_e( 'Company', 'wp-manage-users' ); ?></th>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'Name', 'wp-manage-users' ); ?> :</b>
					{{ user.company.name }}
				</td>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'Catch Phrase', 'wp-manage-users' ); ?> :</b>
					{{ user.company.catchPhrase }}
				</td>
			</tr>
			<tr>
				<td>
					<b><?php esc_html_e( 'BS', 'wp-manage-users' ); ?> :</b>
					{{ user.company.bs }}
				</td>
			</tr>
		</table>

	<#
	} else {
	#>

		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ data.message }}
		</div>

	<# } #>
</script>