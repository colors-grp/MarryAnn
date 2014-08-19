package com.colors.supersaym.dataobjects;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class UserData {
	public String fbid;
	public String name;
	public String rank;
	public String score;

	public UserData() {
	}

	public static UserData userFromJson(JSONObject jsonObject) {
		UserData user = new UserData();
		try {
			user.name = jsonObject.getString("name");
			
			user.fbid = jsonObject.getString("fbid");
			user.score = jsonObject.getString("score");
			user.rank = jsonObject.getString("rank");
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		return user;

	}

}
