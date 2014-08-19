package com.colors.supersaym;

import java.util.ArrayList;
import java.util.HashMap;

import com.colors.supersaym.Views.GuideActivity;
import com.colors.supersaym.dataobjects.GuideData;

import android.app.Activity;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;


public class GuideAdapter extends BaseAdapter {
    
    private Activity activity;
    private ArrayList<GuideData> data;
    private static LayoutInflater inflater=null;
    public ImageLoader imageLoader; 
    

    public GuideAdapter(Activity a, ArrayList<GuideData> d) {
        activity = a;
        data=d;
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        imageLoader=new ImageLoader(activity.getApplicationContext());
    }

    public int getCount() {
    	Log.v("data size", data.size()+"");
        return data.size();
    }

    public GuideData getItem(int position) {
        return data!=null?data.get(position):null;
    }

    public long getItemId(int position) {
        return position;
    }
    
    public View getView(int position, View convertView, ViewGroup parent) {
        View vi=convertView;
        if(convertView==null)
            vi = inflater.inflate(R.layout.activity_guide_list_row, null);

        TextView name = (TextView)vi.findViewById(R.id.title); // title
        ImageView thumb_image=(ImageView)vi.findViewById(R.id.list_image); // thumb image
        
        GuideData mosalsal = new GuideData();
        mosalsal = data.get(position);
        
        // Setting all values in listview
        name.setText(mosalsal.name);
       imageLoader.displayImage(mosalsal.imgUrl, thumb_image);
        return vi;
    }
}