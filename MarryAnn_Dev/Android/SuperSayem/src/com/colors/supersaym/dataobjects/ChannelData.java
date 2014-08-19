package com.colors.supersaym.dataobjects;

import org.json.JSONException;
import org.json.JSONObject;

public class ChannelData {
	public String channel;
	public String  time;
	public ChannelData() {
		
	}
	public static ChannelData channelFromJson(JSONObject jsonObject) {
		ChannelData channel = new ChannelData();
		try {
			channel.channel = jsonObject.getString("channel");
			
			channel.time = jsonObject.getString("time");
			
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		return channel;

	}
		
	

}
