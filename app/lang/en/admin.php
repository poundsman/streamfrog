<?php

return [

	'teams'              => "Teams",
	'streamers'          => "Streamers",
	'stats_heading'      => "Streams",
	'live_right_now'     => "Live right now",
	'close'              => "Close",
	'cancel'             => "Cancel",
	'filter_placeholder' => "Filter...",
	'created_at'         => "Created",
	'updated_at'         => "Last updated",
	'additional_tags'    => "Additional tags",
	'last_edit_by'       => "Last edit by",
	'last_edit_action'   => "Last edit action",
	'no_edits'           => "No edits on record",
	'last_edit_small'    => "Edited :when by :by",
	'no_streamers_found' => "No streamers found",
	'no_teams_found'     => "No teams found",
	'no_edit_allowed'    => "Can not be edited",
	'streamer' => [
		'information'          => "Streamer information: :object",
		'id'                   => "Streamer ID",
		'name'                 => "Streamer name",
		'apikey'               => "Unique API key",
		'team'                 => "Team",
		'team_deleted'         => "Deleted",
		'type'                 => "Platform",
		'twitch'               => "Twitch name",
		'mlg'                  => "MLG ID",
		'url'                  => "Stream URL",
		'twitter'              => "Twitter handle",
		'status'               => "Status",
		'viewers'              => "Viewers",
		'last_live'            => "Last live",
		'never_live'           => "Never",
		'on_deleted_team'      => "Assigned to a deleted team",
		'add_new'              => "Add new streamer",
		'url_help'             => "Format: mlg.tv/stream &#124; twitch.tv/stream",
		'twitter_help'         => "Without @",
		'additional_tags_help' => "Comma separated! &#124; Alias nicknames, alias teamnames etc.",
		'add_new_submit'       => "Add new streamer",
		'subtitle'             => "Member of :team &#124; :type &#124; :twitter",
		'edit'                 => "Edit streamer",
		'edit_submit'          => "Edit streamer",
		'delete'               => "Delete streamer",
		'delete_confirmation'  => "Yes, delete streamer \":streamer\" (Member of :team)",
		'platform' => [
			'mlg'    => "MLG",
			'twitch' => "Twitch"
		]
 	],
 	'team' => [
		'information'          => "Team information: :object",
		'id'                   => "Team ID",
		'name'                 => "Team name",
		'apikey'               => "Unique API key",
		'logo'                 => "Logo class",
		'url'                  => "Team Stream URL",
		'hashtag'              => "Team Hashtag",
		'member_count'         => "Member count",
		'add_new'              => "Add new team",
		'url_help'             => "Format: mlg.tv/stream &#124; twitch.tv/stream",
		'hashtag_help'         => "Without #",
		'additional_tags_help' => "Comma separated! &#124; Alias teamnames etc.",
		'add_new_submit'       => "Add new team",
		'subtitle'             => "Has :members member &#124; :hashtag|Has :members members &#124; :hashtag",
		'delete'               => "Delete team",
		'delete_confirmation'  => "Yes, delete team \":team\" (:members member)|Yes, delete team \":team\" (:members members)",
		'edit'                 => "Edit team",
		'edit_submit'          => "Edit team"
 	],
	'options' => [
		'label'    => "Options",
		'edit'     => "Edit",
		'delete'   => "Delete",
		'history'  => "Edit history",
		'api_call' => "Make API call"
	],
	'history' => [
		'heading' => "Edit history: :object",
		'id'      => "#",
		'by'      => "Edit by",
		'action'  => "Action",
		'date'    => "Date"
	],
	'stats' => [
		'teams_total'                 => "There is :amount team in total|There are :amount teams in total",
		'streamers_total'             => "There is :amount streamer in total|There are :amount streamers in total",
		'live_total'                  => "There is :amount streamer live right now|There are :amount streamers live right now",
		'select_stream_to_view_stats' => "Select a stream to view statistics"
	]
	
];