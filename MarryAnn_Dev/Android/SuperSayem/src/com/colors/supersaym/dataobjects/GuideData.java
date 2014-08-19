package com.colors.supersaym.dataobjects;

import org.json.JSONException;
import org.json.JSONObject;

public class GuideData {
public String name;
public String id;
public String  imgUrl;
public  GuideData() {
	// TODO Auto-generated constructor stub
}

public static GuideData guideFromJson(JSONObject jsonObject) {
	GuideData guide = new GuideData();
	try {
		guide.name = jsonObject.getString("name");
		
		guide.id = jsonObject.getString("id");
		guide.imgUrl="http://hitseven.net/mobile/assets/guide/"+guide.id+".png";
		
	} catch (JSONException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	}

	return guide;

}

}
